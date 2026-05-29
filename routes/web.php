<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Categories\Index as CategoriesIndex;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware([\App\Http\Middleware\RequireEcommerceLicense::class])->group(function () {
    Route::get('/', \App\Livewire\Shop\Index::class)->name('shop.index');
    Route::get('/descargar-precios', [\App\Http\Controllers\PricelistController::class, 'download'])->name('shop.pricelist.download');
    Route::get('/c/{category}', \App\Livewire\Shop\CategoryShow::class)->name('shop.category');
    Route::get('/p/{product}', \App\Livewire\Shop\ProductShow::class)->name('shop.product');
    Route::get('/buscar', \App\Livewire\Shop\SearchShow::class)->name('shop.search');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
});

// Authenticated Routes (all users)
Route::middleware(['auth'])->group(function () {
    Route::get('/pos', \App\Livewire\Pos\SalesInterface::class)->name('pos.index');
    Route::get('/cash', \App\Livewire\Cash\SessionManager::class)->name('cash.index');
    Route::get('/customers', \App\Livewire\Customers\Index::class)->name('customers.index');
    Route::get('/customers/{customer}/statement', [\App\Http\Controllers\ReportsController::class, 'printAccountStatement'])->name('customers.statement');
    Route::get('/sales/{sale}/ticket', [\App\Http\Controllers\TicketController::class, 'show'])->name('sales.ticket');

    // Gerente + Admin Routes (store management)
    Route::middleware(['can:gerente'])->group(function () {
        Route::get('/categories', CategoriesIndex::class)->name('categories.index');
        Route::get('/suppliers', \App\Livewire\Suppliers\Index::class)->name('suppliers.index');
        Route::get('/products', \App\Livewire\Products\Index::class)->name('products.index');
        Route::get('/products/export', [\App\Http\Controllers\ProductImportExportController::class, 'export'])->name('products.export');
        Route::post('/products/import', [\App\Http\Controllers\ProductImportExportController::class, 'import'])->name('products.import');
        Route::get('/products/template', [\App\Http\Controllers\ProductImportExportController::class, 'template'])->name('products.template');
        Route::get('/web-orders', \App\Livewire\Admin\WebOrders\Index::class)->name('admin.web-orders.index');
        Route::get('/sellers', \App\Livewire\Sellers\Index::class)->name('sellers.index');
        
        // Purchases
        Route::get('/purchases', \App\Livewire\Purchases\Index::class)->name('purchases.index');
        Route::get('/purchases/create', \App\Livewire\Purchases\Create::class)->name('purchases.create');

        Route::get('/reports/sales', \App\Livewire\Reports\Sales::class)->name('reports.sales');
        Route::get('/reports/sales/print', [\App\Http\Controllers\ReportsController::class, 'printSales'])->name('reports.sales.print');
        Route::get('/reports/cash', \App\Livewire\Reports\CashSessions::class)->name('reports.cash');
        Route::get('/reports/cash/print', [\App\Http\Controllers\ReportsController::class, 'printCashSessions'])->name('reports.cash.print');
        Route::get('/reports/cash-movements', \App\Livewire\Reports\CashMovements::class)->name('reports.cash-movements');
        Route::get('/reports/vendedores', \App\Livewire\Reports\SalespersonReport::class)->name('reports.salesperson');
        Route::get('/reports/inventario', \App\Livewire\Reports\Inventory::class)->name('reports.inventory');
        Route::get('/reports/inventario/print', [\App\Http\Controllers\ReportsController::class, 'printInventory'])->name('reports.inventory.print');
        Route::get('/reports/saldos-clientes', \App\Livewire\Reports\Debtors::class)->name('reports.debtors');
        Route::get('/reports/utilidad-real', \App\Livewire\Reports\Profit::class)->name('reports.profit');
        Route::get('/expenses', \App\Livewire\Expenses\Index::class)->name('expenses.index');
        Route::get('/expenses/categories', \App\Livewire\Expenses\Categories::class)->name('expenses.categories.index');
    });

    // Admin-Only Routes (system config)
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/users', \App\Livewire\Users\Index::class)->name('users.index');
        Route::get('/settings/branches', \App\Livewire\Branches\Index::class)->name('branches.index');
        Route::get('/settings/registers', \App\Livewire\CashRegisters\Index::class)->name('cash_registers.index');
        Route::get('/settings/general', \App\Livewire\Settings\General::class)->name('settings.general');
        Route::get('/settings/banners', \App\Livewire\Settings\BannerManager::class)->name('settings.banners');
        Route::get('/settings/units', \App\Livewire\Settings\Units::class)->name('settings.units');
        Route::get('/settings/payment-methods', \App\Livewire\Settings\PaymentMethods::class)->name('settings.payment-methods');
        Route::get('/settings/cash-movement-categories', \App\Livewire\Settings\CashMovementCategories::class)->name('settings.cash-movement-categories');
        Route::get('/collections', \App\Livewire\Admin\Collections::class)->name('admin.collections');
        Route::post('/settings/backup', [\App\Http\Controllers\BackupController::class, 'run'])->name('settings.backup.run');
        Route::get('/settings/quotation', \App\Livewire\Settings\Quotation::class)->name('settings.quotation');
    });

    // Master/Developer Routes
    Route::middleware([\App\Http\Middleware\DeveloperOnly::class])->group(function () {
        Route::get('/master/licensing', \App\Livewire\Admin\LicenseManager::class)->name('master.licensing');
    });
});


