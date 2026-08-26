<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Customer;

class GlobalCommandPalette extends Component
{
    public bool $isOpen = false;
    public string $query = '';
    public int $selectedIndex = 0;

    protected $listeners = [
        'open-command-palette' => 'open',
        'close-command-palette' => 'close',
    ];

    public function open(): void
    {
        $this->isOpen = true;
        $this->query = '';
        $this->selectedIndex = 0;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->query = '';
        $this->selectedIndex = 0;
    }

    public function render()
    {
        $navigationItems = $this->getNavigationItems();
        $filteredNav = [];
        $products = [];
        $customers = [];

        $q = trim($this->query);

        if ($q !== '') {
            $filteredNav = array_values(array_filter($navigationItems, function ($item) use ($q) {
                return mb_stripos($item['title'], $q) !== false 
                    || mb_stripos($item['category'], $q) !== false 
                    || mb_stripos($item['keywords'] ?? '', $q) !== false;
            }));

            // Search Products
            $products = Product::where('is_active', true)
                ->where(function ($query) use ($q) {
                    $query->where('name', 'LIKE', "%{$q}%")
                          ->orWhere('sku', 'LIKE', "%{$q}%");
                })
                ->take(6)
                ->get();

            // Search Customers
            $customers = Customer::where('is_active', true)
                ->where(function ($query) use ($q) {
                    $query->where('name', 'LIKE', "%{$q}%")
                          ->orWhere('phone', 'LIKE', "%{$q}%")
                          ->orWhere('document_number', 'LIKE', "%{$q}%");
                })
                ->take(4)
                ->get();
        } else {
            // Default top suggestions
            $filteredNav = array_slice($navigationItems, 0, 8);
        }

        return view('livewire.admin.global-command-palette', [
            'filteredNav' => $filteredNav,
            'products' => $products,
            'customers' => $customers,
        ]);
    }

    private function getNavigationItems(): array
    {
        return [
            // Operaciones / POS
            ['title' => 'Punto de Venta (Caja POS)', 'category' => 'Vender', 'url' => route('pos.index'), 'icon' => '⚡', 'keywords' => 'vender caja facturar cobrar'],
            ['title' => 'Directorio de Clientes', 'category' => 'Vender', 'url' => route('customers.index'), 'icon' => '👥', 'keywords' => 'clientes personas compradores'],
            ['title' => 'Cuentas Corrientes y Cobranzas', 'category' => 'Vender', 'url' => route('admin.collections'), 'icon' => '💳', 'keywords' => 'deudas saldo cobrar creditos'],
            
            // Catálogo
            ['title' => 'Catálogo de Productos', 'category' => 'Catálogo', 'url' => route('products.index'), 'icon' => '📦', 'keywords' => 'articulos stock inventario items'],
            ['title' => 'Crear Nuevo Producto', 'category' => 'Catálogo', 'url' => route('products.create'), 'icon' => '➕', 'keywords' => 'agregar producto nuevo'],
            ['title' => 'Categorías de Productos', 'category' => 'Catálogo', 'url' => route('categories.index'), 'icon' => '🏷️', 'keywords' => 'familias rubros'],
            ['title' => 'Generador de Etiquetas & Barcodes', 'category' => 'Catálogo', 'url' => route('products.print-labels'), 'icon' => '🖨️', 'keywords' => 'imprimir codigos barras rotulos'],
            ['title' => 'Unidades de Medida', 'category' => 'Catálogo', 'url' => route('settings.units'), 'icon' => '⚖️', 'keywords' => 'kilos gramos litros unidades'],

            // Gestión
            ['title' => 'Taller de Desposte y Cortes', 'category' => 'Gestión', 'url' => route('admin.deboning.index'), 'icon' => '🥩', 'keywords' => 'carne faena rendimiento cortes'],
            ['title' => 'Facturas de Compra / Entradas', 'category' => 'Gestión', 'url' => route('purchases.index'), 'icon' => '📥', 'keywords' => 'compras gastos proveedores mercaderia'],
            ['title' => 'Directorio de Proveedores', 'category' => 'Gestión', 'url' => route('suppliers.index'), 'icon' => '🏭', 'keywords' => 'proveedores distribuidores'],
            ['title' => 'Gastos y Egresos', 'category' => 'Finanzas', 'url' => route('expenses.index'), 'icon' => '💸', 'keywords' => 'egresos costos salidas dinero'],

            // Reportes
            ['title' => 'Reporte Detalle de Ventas', 'category' => 'Estadísticas', 'url' => route('reports.sales'), 'icon' => '📊', 'keywords' => 'ventas ingresos facturado historico'],
            ['title' => 'Ranking de Vendedores', 'category' => 'Estadísticas', 'url' => route('reports.salesperson'), 'icon' => '🏆', 'keywords' => 'comisiones mejores vendedores'],
            ['title' => 'Estado de Inventario y Stock', 'category' => 'Estadísticas', 'url' => route('reports.inventory'), 'icon' => '📦', 'keywords' => 'valorizado inventario faltantes'],
            ['title' => 'Saldos Deudores de Clientes', 'category' => 'Estadísticas', 'url' => route('reports.debtors'), 'icon' => '📋', 'keywords' => 'cuentas por cobrar morosos'],

            // Configuración
            ['title' => 'Ajustes Generales del Negocio', 'category' => 'Configuración', 'url' => route('settings.general'), 'icon' => '⚙️', 'keywords' => 'nombre logo ruc moneda ticket'],
            ['title' => 'Sucursales', 'category' => 'Administración', 'url' => route('branches.index'), 'icon' => '🏢', 'keywords' => 'locales tiendas depositos'],
            ['title' => 'Puntos de Venta (Cajas)', 'category' => 'Administración', 'url' => route('cash_registers.index'), 'icon' => '💻', 'keywords' => 'terminales pos registradoras'],
            ['title' => 'Usuarios y Roles', 'category' => 'Administración', 'url' => route('users.index'), 'icon' => '🔑', 'keywords' => 'empleados cajeros permisos'],
            ['title' => 'Mi Sesión de Caja', 'category' => 'Caja', 'url' => route('cash.index'), 'icon' => '💵', 'keywords' => 'cierre arqueo apertura caja chica'],
            ['title' => 'Dashboard Principal', 'category' => 'Inicio', 'url' => route('dashboard'), 'icon' => '📈', 'keywords' => 'inicio metricas resumen kpi'],
        ];
    }
}
