<?php

use App\Models\User;
use App\Models\Product;
use App\Models\CashSession;
use App\Models\Sale;
use App\Models\Payment;
use App\Livewire\Pos\SalesInterface;
use Livewire\Livewire;

try {
    echo "Creating User...\n";
    $user = User::first();
    if (!$user) {
        $user = User::factory()->create();
    }
    auth()->login($user);

    echo "Creating Session...\n";
    // Check if open session exists
    $session = CashSession::where('user_id', $user->id)->where('status', 'open')->first();
    if (!$session) {
        CashSession::create([
            'user_id' => $user->id,
            'opened_at' => now(),
            'opening_amount' => 100000,
            'status' => 'open'
        ]);
    }

    echo "Creating Product...\n";
    $product = Product::forceCreate([
        'name' => 'Producto Debug Cheque',
        'sku' => 'DEBUG-CHEQUE-' . rand(1000, 9999),
        'price_sale' => 150000,
        'price_cost' => 100000,
        'stock' => 10,
        'manage_stock' => true,
        'is_active' => true
    ]);

    echo "Simulating Livewire...\n";
    $component = Livewire::test(SalesInterface::class);
    
    echo "Adding to Cart...\n";
    $component->call('addToCart', $product->id);
    
    echo "Setting Payment Method...\n";
    $component->set('paymentMethod', 'cheque');
    
    echo "Setting Cheque Details...\n";
    $component->set('chequeDetails', [
        'bank_name' => 'Banco Debug',
        'cheque_number' => 'DBG-999',
        'due_date' => now()->addDays(30)->format('Y-m-d')
    ]);
    
    echo "Processing Sale...\n";
    $component->call('processSale');
    
    echo "Checking Database...\n";
    $sale = Sale::latest()->first();
    if ($sale) {
        echo "Sale created: " . $sale->id . "\n";
        $payment = Payment::where('sale_id', $sale->id)->first();
        if ($payment) {
            echo "Payment created: " . $payment->method . "\n";
            echo "Bank: " . $payment->bank_name . "\n";
        } else {
            echo "Payment NOT found!\n";
        }
    } else {
        echo "Sale NOT found!\n";
    }

} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
} catch (\Throwable $e) {
    echo "THROWABLE: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
