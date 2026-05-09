<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Validation\Rule;
use App\Models\CustomerTransaction;

class SalesInterface extends Component
{
    public $search = '';
    public $cart = [];
    public $total = 0;
    public $selectedCategory = null;
    public $lastSaleId;
    public $rates = [];
    
    // Variation Selection
    public $showVariationModal = false;
    public $selectingProduct = null;
    public $variationId = '';

    // Discount
    public $discountProductEnabled = false;
    public $discountManualEnabled  = false;
    public $manualDiscountPct = 0;  // 0-100
    public $discountAmount = 0;
    public $subtotalBeforeDiscount = 0;
    
    // Customer Management
    public $selectedCustomer = null;
    public $customerSearch = '';
    public $searchResults = [];
    public $showCustomerModal = false;
    
    // New Customer Form
    public $newCustomerName = '';
    public $newCustomerRuc = '';
    public $newCustomerEmail = '';
    public $newCustomerPhone = '';
    public $newCustomerAddress = '';
    public $newCustomerIsActive = true;

    // New Product Form
    public $showProductModal = false;
    public $newProductName = '';
    public $newProductSku = '';
    public $newProductCategoryId = '';
    public $newProductPriceCost = '';
    public $newProductPriceSale = '';
    public $newProductStock = 0;
    public $newProductMinStock = 5;
    public $newProductUnitType = 'unit';
    public $newProductManageStock = true;
    public $newProductIsActive = true;

    // Session Status Logic
    public $showStatusModal = false;
    public $sessionDetails = [
        'opened_at' => null,
        'opening_amount' => 0,
        'sales_count' => 0,
        'sales_total' => 0,
        'total_in' => 0,
        'total_out' => 0,
        'expected_total' => 0
    ];

    // Void Sale from POS
    public $showVoidModal = false;
    public $voidSearch = '';
    public $recentSales = [];

    public $currentRegisterName = null;
    public $sessionOpenedAt = null;

    // Web Orders Integration
    public $pendingWebOrders = [];
    public $showWebOrdersModal = false;
    public $importingWebOrderId = null;

    public function mount()
    {
        // Check Session
        $session = \App\Models\CashSession::with('register')
            ->where('user_id', auth()->id())
            ->where('status', 'open')
            ->latest()
            ->first();

        if (!$session) {
            return redirect()->route('cash.index')->with('message', 'Debes abrir caja para poder vender.');
        }

        // Store session info for the header badge
        $this->currentRegisterName = $session->register?->name ?? 'Caja';
        $this->sessionOpenedAt    = $session->opened_at->format('H:i');

        // Load Rates
        $settings = \App\Models\StoreSetting::whereIn('key', [
            'currency_usd', 'currency_brl', 'currency_ars', 'currency_eur',
            'discount_product_enabled', 'discount_manual_enabled'
        ])->pluck('value', 'key');

        $this->rates = [
            'usd' => (float) $settings->get('currency_usd', 0),
            'brl' => (float) $settings->get('currency_brl', 0),
            'ars' => (float) $settings->get('currency_ars', 0),
            'eur' => (float) $settings->get('currency_eur', 0),
        ];

        $this->discountProductEnabled = $settings->get('discount_product_enabled', '0') === '1';
        $this->discountManualEnabled  = $settings->get('discount_manual_enabled', '0') === '1';
    }

    public function render()
    {
        $products = Product::where('is_active', true)
            ->where(function($query) {
                // MySQL uses LIKE for case-insensitive search
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategory, function($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->take(20)
            ->get();

        $categories = Category::where('is_active', true)->get();

        return view('livewire.pos.sales-interface', [
            'products' => $products,
            'categories' => $categories,
            'movementCategories' => \App\Models\CashMovement::CATEGORIES,
            'pendingWebOrdersCount' => \App\Models\WebOrder::whereIn('status', ['Pendiente WhatsApp', 'Atendido'])->count()
        ])->layout('layouts.pos');
    }

    public function filterCategory($categoryId)
    {
        $this->selectedCategory = $categoryId === $this->selectedCategory ? null : $categoryId;
    }

    public function addToCart($productId)
    {
        $product = Product::with('variations')->find($productId);
        if (!$product) return;

        if ($product->has_variations) {
            $this->selectingProduct = $product;
            $this->showVariationModal = true;
            return;
        }

        $this->addToCartInternal($product);
    }

    public function selectVariation($variationId)
    {
        $variation = \App\Models\ProductVariation::find($variationId);
        if (!$variation) return;

        $this->addToCartInternal($this->selectingProduct, $variation);
        $this->showVariationModal = false;
        $this->selectingProduct = null;
    }

    protected function addToCartInternal($product, $variation = null)
    {
        $cartKey = $variation ? 'v' . $variation->id : 'p' . $product->id;
        
        $name = $product->name . ($variation ? ' (' . $variation->name . ')' : '');
        $price = $variation ? $variation->price_sale : $product->price_sale;
        $sku = $variation ? $variation->sku : $product->sku;
        $stock = $variation ? $variation->stock : $product->stock;

        // Stock Validation
        if ($product->manage_stock) {
            $currentQty = isset($this->cart[$cartKey]) ? $this->cart[$cartKey]['quantity'] : 0;
            if ($stock < ($currentQty + 1)) {
                $this->dispatch('error-movement', 'Stock insuficiente. Disponible: ' . $stock);
                return;
            }
        }

        if(isset($this->cart[$cartKey])) {
            $this->cart[$cartKey]['quantity']++;
        } else {
            // Apply product discount if setting is enabled
            $effectivePrice = ($this->discountProductEnabled && $product->discount_percentage > 0)
                ? (int) round($price * (1 - $product->discount_percentage / 100))
                : $price;

            $this->cart[$cartKey] = [
                'id'               => $product->id,
                'variation_id'     => $variation ? $variation->id : null,
                'name'             => $name,
                'price'            => $effectivePrice,
                'original_price'   => $price,
                'discount_pct'     => ($this->discountProductEnabled) ? $product->discount_percentage : 0,
                'quantity'         => 1,
                'unit_type'        => $product->unit_type ?? 'unit',
                'sku'              => $sku
            ];
        }
        
        $this->calculateTotal();
    }

    public function updateQuantity($cartKey, $change)
    {
        if(!isset($this->cart[$cartKey])) return;

        $item = $this->cart[$cartKey];
        $product = Product::find($item['id']);
        $variation = $item['variation_id'] ? \App\Models\ProductVariation::find($item['variation_id']) : null;
        
        $stock = $variation ? $variation->stock : ($product ? $product->stock : 0);
        $newQty = $item['quantity'] + $change;

        // Stock Validation on Increase
        if ($change > 0 && $product && $product->manage_stock) {
            if ($stock < $newQty) {
                $this->dispatch('error-movement', 'Stock insuficiente. Disponible: ' . $stock);
                return;
            }
        }

        $this->cart[$cartKey]['quantity'] += $change;

        if($this->cart[$cartKey]['quantity'] <= 0) {
            unset($this->cart[$cartKey]);
        }

        $this->calculateTotal();
    }

    public function setQuantity($cartKey, $quantity)
    {
        if(!isset($this->cart[$cartKey])) return;
        
        $quantity = (float) $quantity;
        
        if($quantity <= 0) {
            unset($this->cart[$cartKey]);
        } else {
            $this->cart[$cartKey]['quantity'] = $quantity;
        }

        $this->calculateTotal();
    }

    public function removeFromCart($cartKey)
    {
        unset($this->cart[$cartKey]);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $this->subtotalBeforeDiscount = $subtotal;

        // Apply manual discount on top
        if ($this->discountManualEnabled && $this->manualDiscountPct > 0) {
            $this->discountAmount = (int) round($subtotal * $this->manualDiscountPct / 100);
        } else {
            $this->discountAmount = 0;
        }

        $this->total = $subtotal - $this->discountAmount;
    }

    public function updatedManualDiscountPct()
    {
        $this->manualDiscountPct = max(0, min(100, (int) $this->manualDiscountPct));
        $this->calculateTotal();
    }

    // Movement logic
    public $showMovementModal = false;
    public $showMobileCart = false; // New property for Mobile Cart
    public $movementType = 'out';
    public $movementAmount = '';
    public $movementDescription = '';
    public $movementCategory = '';

    public function toggleMobileCart()
    {
        $this->showMobileCart = !$this->showMobileCart;
    }

    public function openMovementModal($type)
    {
        $hasOpenSession = \App\Models\CashSession::where('user_id', auth()->id())
            ->where('status', 'open')
            ->exists();

        if (!$hasOpenSession) {
            return redirect()->route('cash.index')->with('message', 'Debes abrir caja para registrar movimientos.');
        }

        $this->movementType = $type;
        $this->movementAmount = '';
        $this->movementDescription = '';
        $this->movementCategory = '';
        $this->showMovementModal = true;
    }

    public function saveMovement()
    {
        $this->validate([
            'movementAmount' => 'required|numeric|min:0',
            'movementDescription' => 'required|string|max:255',
            'movementCategory' => 'nullable|string|max:50'
        ]);

        $currentSession = \App\Models\CashSession::where('user_id', auth()->id())
            ->where('status', 'open')
            ->latest()
            ->first();

        if (!$currentSession) {
             session()->flash('message', 'No hay sesión de caja abierta.');
             return;
        }

        $currentSession->movements()->create([
            'type' => $this->movementType,
            'category' => $this->movementCategory ?: null,
            'amount' => $this->movementAmount,
            'description' => $this->movementDescription
        ]);

        $this->showMovementModal = false;
        
        // Notify success
        $this->dispatch('session-status-changed'); 
        session()->flash('success_movement', 'Movimiento registrado correctamente.');
    }

    public function openStatusModal()
    {
        $hasOpenSession = \App\Models\CashSession::where('user_id', auth()->id())
            ->where('status', 'open')
            ->exists();

        if (!$hasOpenSession) {
            return redirect()->route('cash.index')->with('message', 'Debes abrir caja para ver el estado.');
        }

        $this->loadSessionDetails();
        $this->showStatusModal = true;
    }

    public function loadSessionDetails()
    {
        $session = \App\Models\CashSession::where('user_id', auth()->id())
            ->where('status', 'open')
            ->latest()
            ->first();

        if (!$session) return;

        $sales = \App\Models\Sale::where('user_id', auth()->id())
            ->where('created_at', '>=', $session->opened_at)
            ->get();
        
        $totalSales = $sales->sum('total');
        
        // Calculate amount that actually entered as CASH
        $cashSales = \App\Models\Payment::whereIn('sale_id', $sales->pluck('id'))
            ->where('method', 'efectivo')
            ->sum('amount');
        
        $totalIn = $session->movements()->where('type', 'in')->sum('amount');
        $totalOut = $session->movements()->where('type', 'out')->sum('amount');

        $this->sessionDetails = [
            'opened_at' => $session->opened_at,
            'opening_amount' => $session->opening_amount,
            'sales_count' => $sales->count(),
            'sales_total' => $totalSales,
            'sales_cash' => $cashSales,
            'total_in' => $totalIn,
            'total_out' => $totalOut,
            'expected_total' => $session->opening_amount + $cashSales + $totalIn - $totalOut
        ];
    }

    public function updatedCustomerSearch()
    {
        if (strlen($this->customerSearch) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = \App\Models\Customer::where('is_active', true)
            ->where(function ($query) {
                // MySQL uses LIKE for case-insensitive search
                $query->where('name', 'like', '%' . $this->customerSearch . '%')
                      ->orWhere('ruc', 'like', '%' . $this->customerSearch . '%');
            })
            ->take(5)
            ->get()
            ->toArray();
    }

    public function selectCustomer($customerId)
    {
        $customer = \App\Models\Customer::find($customerId);
        if ($customer) {
            $this->selectedCustomer = $customer->toArray();
            $this->customerSearch = '';
            $this->searchResults = [];
        }
    }

    public function openCreateCustomerModal()
    {
        $this->reset(['newCustomerName', 'newCustomerRuc', 'newCustomerEmail', 'newCustomerPhone', 'newCustomerAddress', 'newCustomerIsActive']);
        $this->showCustomerModal = true;
        // Clear search to close the dropdown behind the modal
        $this->searchResults = [];
    }

    public function removeCustomer()
    {
        $this->selectedCustomer = null;
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->importingWebOrderId = null;
        $this->calculateTotal();
    }

    // ---- Web Orders Integration ----
    public function openWebOrdersModal()
    {
        $this->pendingWebOrders = \App\Models\WebOrder::with('product')
            ->whereIn('status', ['Pendiente WhatsApp', 'Atendido'])
            ->orderByDesc('created_at')
            ->get()
            ->toArray();
        $this->showWebOrdersModal = true;
    }

    public function importWebOrder($orderId)
    {
        $order = \App\Models\WebOrder::with('product')->find($orderId);
        if (!$order) return;

        // Clear current cart or ask? For now, clear.
        $this->cart = [];
        $this->importingWebOrderId = $order->id;

        if ($order->items_json) {
            foreach ($order->items_json as $item) {
                // Try to find the actual product for accurate stock/price
                $product = Product::find($item['id']);
                if ($product) {
                    $this->addToCart($product->id);
                    // Update quantity if more than 1
                    if ($item['quantity'] > 1) {
                        $this->cart[$product->id]['quantity'] = $item['quantity'];
                    }
                } else {
                    // Fallback for custom/deleted items (not ideal for POS but better than nothing)
                    $this->cart[$item['id']] = [
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'unit_type' => 'unit'
                    ];
                }
            }
        } elseif ($order->product_id) {
            $this->addToCart($order->product_id);
        }

        // Try to match customer by phone
        $customer = \App\Models\Customer::where('phone', $order->customer_phone)->first();
        if ($customer) {
            $this->selectedCustomer = $customer->toArray();
        } else {
            // Pre-fill name for search or create?
            $this->customerSearch = $order->customer_name;
        }

        $this->calculateTotal();
        $this->showWebOrdersModal = false;
        $this->dispatch('success-movement', 'Pedido Web #' . substr($order->id, 0, 8) . ' importado.');
    }

    public function saveNewCustomer()
    {
        $this->validate([
            'newCustomerName' => 'required|string|max:255',
            'newCustomerRuc' => ['required', 'string', 'max:20'],
            'newCustomerEmail' => ['nullable', 'email', 'max:255'],
            'newCustomerPhone' => ['nullable', 'string', 'max:20'],
            'newCustomerAddress' => ['nullable', 'string', 'max:500'],
        ]);

        if (\App\Models\Customer::where('ruc', $this->newCustomerRuc)->exists()) {
            $this->addError('newCustomerRuc', 'Ya existe un cliente con este RUC.');
            return;
        }

        $customer = \App\Models\Customer::create([
            'name' => $this->newCustomerName,
            'ruc' => $this->newCustomerRuc,
            'email' => $this->newCustomerEmail,
            'phone' => $this->newCustomerPhone,
            'address' => $this->newCustomerAddress,
            'is_active' => $this->newCustomerIsActive
        ]);

        $this->selectedCustomer = $customer->toArray();
        $this->showCustomerModal = false;
        $this->reset(['newCustomerName', 'newCustomerRuc', 'newCustomerEmail', 'newCustomerPhone', 'newCustomerAddress', 'newCustomerIsActive']);
        
        $this->dispatch('success-movement', 'Cliente creado correctamente.');
        $this->searchResults = [];
    }

    public function openCreateProductModal()
    {
        $this->reset(['newProductName', 'newProductSku', 'newProductCategoryId', 'newProductPriceCost', 'newProductPriceSale', 'newProductStock', 'newProductMinStock', 'newProductUnitType', 'newProductManageStock', 'newProductIsActive']);
        // If user typed something in search, maybe use it as name? Optional UX improvement.
        if(!empty($this->search)) {
            $this->newProductName = $this->search; 
        }
        $this->showProductModal = true;
    }

    public function saveNewProduct()
    {
        $this->validate([
            'newProductName' => 'required|min:3',
            'newProductSku' => 'nullable|unique:products,sku',
            'newProductPriceCost' => 'required',
            'newProductPriceSale' => 'required',
            'newProductStock' => $this->newProductManageStock ? 'required|numeric|min:0' : 'nullable',
            'newProductMinStock' => $this->newProductManageStock ? 'required|numeric|min:0' : 'nullable',
            'newProductCategoryId' => 'nullable|exists:categories,id',
            'newProductUnitType' => 'required|in:unit,kg,liter,meter'
        ]);

        // Auto-generate SKU if empty
        if (empty($this->newProductSku)) {
            do {
                $this->newProductSku = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
            } while (\App\Models\Product::where('sku', $this->newProductSku)->exists());
        }

        $product = \App\Models\Product::create([
            'name' => $this->newProductName,
            'sku' => $this->newProductSku,
            'price_cost' => $this->newProductPriceCost,
            'price_sale' => $this->newProductPriceSale,
            'stock' => $this->newProductManageStock ? $this->newProductStock : 0,
            'min_stock' => $this->newProductManageStock ? $this->newProductMinStock : 0,
            'category_id' => $this->newProductCategoryId ?: null,
            'unit_type' => $this->newProductUnitType,
            'manage_stock' => $this->newProductManageStock,
            'is_active' => $this->newProductIsActive
        ]);

        $this->showProductModal = false;
        $this->reset(['newProductName', 'newProductSku', 'newProductCategoryId', 'newProductPriceCost', 'newProductPriceSale', 'newProductStock', 'newProductMinStock', 'newProductUnitType', 'newProductManageStock', 'newProductIsActive']);
        
        // Add to cart automatically
        $this->addToCart($product->id);
        
        $this->dispatch('success-movement', 'Producto creado y agregado al carrito.');
        
        // Clear search so the list refreshes or user can search again
        $this->search = ''; 
    }

    // Payment Logic
    public $showPaymentModal = false;
    public $paymentMethod = 'efectivo'; // efectivo, pos, tarjeta, transferencia, multiple
    public $receivedAmount = 0;
    public $change = 0;
    public $paymentCondition = 'contado'; // contado, credito
    public $multiplePayments = []; // Stores amounts for split payments
    public $chequeDetails = [
        'bank_name' => '',
        'cheque_number' => '',
        'due_date' => '',
    ];

    // Seller
    public $sellerId = null;
    public $sellerOptions = [];

    public function openPaymentModal()
    {
        if(empty($this->cart)) return;
        
        // Check session before opening modal to avoid frustration
        $hasOpenSession = \App\Models\CashSession::where('user_id', auth()->id())
            ->where('status', 'open')
            ->exists();

        if (!$hasOpenSession) {
            return redirect()->route('cash.index')->with('message', 'Debes abrir caja para poder vender.');
        }

        $this->paymentMethod = 'efectivo';
        $this->paymentCondition = 'contado';
        $this->receivedAmount = ''; // Start empty so user can type
        $this->change = -$this->total; // Initial change is effectively negative whole amount
        $this->showPaymentModal = true;
        
        // Initialize multiple payments
        $this->multiplePayments = [
            'efectivo' => 0,
            'tarjeta' => 0,
            'transferencia' => 0,
            'qr' => 0
        ];
        $this->chequeDetails = [
            'bank_name' => '',
            'cheque_number' => '',
            'due_date' => '',
        ];

        // Load active sellers
        $this->sellerId = null;
        $this->sellerOptions = \App\Models\Seller::where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function updatedReceivedAmount()
    {
        // Simple sanitation if needed, but type="number" usually suffices
        // If handling "1.000" format, we need to clean standardizing 
        $this->calculateChange();
    }

    public function updatedPaymentMethod()
    {
        if ($this->paymentMethod === 'multiple') {
            $this->receivedAmount = 0;
            // Maybe initialize with total in cash?
            $this->multiplePayments['efectivo'] = $this->total; 
            $this->multiplePayments['tarjeta'] = 0;
            $this->multiplePayments['transferencia'] = 0;
            $this->multiplePayments['qr'] = 0;
        } elseif ($this->paymentMethod === 'cheque') {
            // For cheque, we usually don't need 'receivedAmount' behavior like cash change
            // But we do need to set it to total so validation passes (received >= total)
            $this->receivedAmount = $this->total;
        } elseif ($this->paymentMethod !== 'efectivo') {
            $this->receivedAmount = $this->total;
        } else {
            // Restore received amount relative to logic? 
            // Or reset? Usually reset to force entry or keep if valid.
            // Let's reset to empty or 0 if returning to cash
             if($this->receivedAmount == $this->total) $this->receivedAmount = ''; 
        }
        $this->calculateChange();
    }

    public function updatedPaymentCondition()
    {
        if ($this->paymentCondition === 'credito') {
            // Logic for credit? Maybe clear payment method selection or just ignore it.
        } else {
            $this->paymentMethod = 'efectivo'; // Default back to cash
        }
    }

    public function calculateChange()
    {
        if ($this->paymentMethod === 'multiple') {
            $totalPaid = array_sum($this->multiplePayments);
            $this->receivedAmount = $totalPaid;
            $this->change = $totalPaid - $this->total;
        } elseif ($this->paymentMethod === 'efectivo') {
            // Cast to float to safely do math, then subtract
            $received = (float) $this->receivedAmount;
            $this->change = $received - $this->total;
        } else {
            $this->change = 0;
        }
    }

    // Listener for multiple payments updates
    public function updatedMultiplePayments()
    {
        $this->calculateChange();
    }

    public function processSale()
    {
        if(empty($this->cart)) return;

        // Double check session
        $hasOpenSession = \App\Models\CashSession::where('user_id', auth()->id())
            ->where('status', 'open')
            ->exists();

        if (!$hasOpenSession) {
            return redirect()->route('cash.index')->with('message', 'La caja se ha cerrado. Abrela para continuar.');
        }

        // Validate Payment (Only if Contado)
        if ($this->paymentCondition === 'contado') {
            if ($this->paymentMethod === 'efectivo') {
                if ($this->receivedAmount <= 0) {
                     $this->addError('receivedAmount', 'El monto recibido debe ser mayor a 0.');
                     return;
                }
                if ($this->receivedAmount < $this->total) {
                    $this->addError('receivedAmount', 'El monto recibido es menor al total.');
                    return;
                }
            } elseif ($this->paymentMethod === 'multiple') {
                if ($this->receivedAmount < $this->total) {
                    $this->addError('multiplePayments', 'La suma de pagos (' . number_format($this->receivedAmount, 0, '', '.') . ') es menor al total.');
                    return;
                }
                
                // Validate that at least one amount is > 0
                 if ($this->receivedAmount <= 0) {
                     $this->addError('multiplePayments', 'Debes ingresar un monto.');
                     return;
                }
            } elseif ($this->paymentMethod === 'cheque') {
                $this->validate([
                    'chequeDetails.bank_name' => 'required|string|max:100',
                    'chequeDetails.cheque_number' => 'required|string|max:50',
                    'chequeDetails.due_date' => 'required|date',
                ]);
            }
        }

        // Validate Credit
        if ($this->paymentCondition === 'credito' && !$this->selectedCustomer) {
            $this->dispatch('error-movement', 'Para ventas a Crédito, debes seleccionar un Cliente.');
            return;
        }

        try {
            \DB::transaction(function () {
                // 1. Create Sale
                $sale = \App\Models\Sale::create([
                    'user_id'                  => auth()->id(),
                    'seller_id'                => $this->sellerId ?: null,
                    'customer_id'              => $this->selectedCustomer ? $this->selectedCustomer['id'] : null,
                    'subtotal_before_discount' => $this->subtotalBeforeDiscount,
                    'discount_amount'          => $this->discountAmount,
                    'total'                    => $this->total,
                    'tax_10'                   => (int) round($this->total / 11),
                    'tax_5'                    => 0,
                    'tax_exempt'               => 0,
                    'status'                   => 'completed',
                    'payment_condition'        => $this->paymentCondition,
                    'web_order_id'             => $this->importingWebOrderId
                ]);

                // 2. Create Items & Deduct Stock
                foreach ($this->cart as $item) {
                    $product = Product::lockForUpdate()->find($item['id']);
                    $variation = $item['variation_id'] ? \App\Models\ProductVariation::lockForUpdate()->find($item['variation_id']) : null;
                    
                    if (!$product) {
                        throw new \Exception("El producto '{$item['name']}' ya no existe en la base de datos.");
                    }

                    if ($product->manage_stock) {
                        $stockToCheck = $variation ? $variation->stock : $product->stock;
                        
                        if ($stockToCheck < $item['quantity']) {
                            throw new \Exception("Stock insuficiente para: " . $item['name']);
                        }

                        if ($variation) {
                            $variation->decrement('stock', $item['quantity']);
                        } else {
                            $product->decrement('stock', $item['quantity']);
                        }
                    }
                    
                    \App\Models\SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item['id'],
                        'product_variation_id' => $item['variation_id'],
                        'product_name' => $item['name'],
                        'quantity' => $item['quantity'],
                        'price_unit' => $item['price'],
                        'subtotal' => $item['price'] * $item['quantity']
                    ]);
                }

                // 3. Create Payment (Only if Contado)
                if ($this->paymentCondition === 'contado') {
                    if ($this->paymentMethod === 'multiple') {
                        foreach ($this->multiplePayments as $method => $amount) {
                            if ($amount > 0) {
                                \App\Models\Payment::create([
                                    'sale_id' => $sale->id,
                                    'method' => $method,
                                    'amount' => $amount,
                                ]);
                            }
                        }
                    } else {
                        $paymentData = [
                            'sale_id' => $sale->id,
                            'method' => $this->paymentMethod,
                            'amount' => $this->total,
                        ];

                        if ($this->paymentMethod === 'cheque') {
                            $paymentData['bank_name'] = $this->chequeDetails['bank_name'];
                            $paymentData['cheque_number'] = $this->chequeDetails['cheque_number'];
                            $paymentData['due_date'] = $this->chequeDetails['due_date'];
                        }

                        \App\Models\Payment::create($paymentData);
                    }
                } elseif ($this->paymentCondition === 'credito' && $sale->customer_id) {
                    CustomerTransaction::create([
                        'customer_id' => $sale->customer_id,
                        'type' => 'debit',
                        'amount' => $this->total,
                        'reference_type' => 'sale',
                        'reference_id' => $sale->id,
                        'description' => 'Venta #' . $sale->id
                    ]);
                }
                
                $this->lastSaleId = $sale->id;

                // 4. Complete Web Order if applicable
                if ($this->importingWebOrderId) {
                    \App\Models\WebOrder::where('id', $this->importingWebOrderId)
                        ->update(['status' => 'Completado']);
                }
            });

            $this->cart = [];
            $this->total = 0;
            $this->selectedCustomer = null;
            $this->customerSearch = '';
            $this->importingWebOrderId = null;
            $this->showPaymentModal = false; // Close modal
            session()->flash('success', 'Venta procesada correctamente');
            session()->flash('last_sale_id', $this->lastSaleId);

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function printLastTicket()
    {
        if ($this->lastSaleId) {
            $this->dispatch('print-ticket', ['saleId' => $this->lastSaleId]);
        }
    }

    // ---- Void Sale from POS ----
    public function openVoidModal()
    {
        $this->recentSales   = \App\Models\Sale::with(['customer', 'seller'])
            ->where('status', '!=', 'voided')
            ->whereDate('created_at', today())
            ->orderByDesc('created_at')
            ->take(10)
            ->get()
            ->toArray();
        $this->voidSearch    = '';
        $this->showVoidModal = true;
    }

    public function updatedVoidSearch()
    {
        if (strlen($this->voidSearch) >= 2) {
            $this->recentSales = \App\Models\Sale::with(['customer', 'seller'])
                ->where('status', '!=', 'voided')
                ->where(function($q) {
                    $q->whereHas('customer', fn($c) => $c->where('name', 'like', '%'.$this->voidSearch.'%'))
                      ->orWhere('id', 'like', '%'.$this->voidSearch.'%');
                })
                ->orderByDesc('created_at')
                ->take(10)
                ->get()
                ->toArray();
        }
    }

    public function voidSale($saleId)
    {
        $sale = \App\Models\Sale::with('items.product')->findOrFail($saleId);

        if ($sale->status === 'voided') {
            session()->flash('error', 'Esta venta ya fue anulada.');
            return;
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($sale) {
            // Restore stock
            foreach ($sale->items as $item) {
                if ($item->product && $item->product->manage_stock) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            // Mark as voided
            $sale->update(['status' => 'voided']);
        });

        $this->showVoidModal = false;
        session()->flash('success', 'Venta anulada y stock restaurado.');
    }
}
