<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\CashSession;
use App\Models\CashRegister;
use App\Models\Branch;
use App\Models\BranchStock;
use Livewire\Livewire;
use App\Livewire\Pos\SalesInterface;
use App\Models\Payment;
use App\Models\Sale;

class ChequePaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_process_sale_with_cheque_payment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Setup Branch and Register
        $branch = Branch::create([
            'name' => 'Sucursal Central',
            'address' => 'Asuncion',
            'is_active' => true
        ]);

        $register = CashRegister::create([
            'name' => 'Caja Central',
            'branch_id' => $branch->id,
            'active' => true
        ]);

        // Open Session
        CashSession::create([
            'user_id' => $user->id,
            'cash_register_id' => $register->id,
            'opened_at' => now(),
            'opening_amount' => 100000,
            'status' => 'open'
        ]);

        $product = Product::forceCreate([
            'name' => 'Producto Cheque',
            'sku' => 'CHEQUE-001',
            'price_sale' => 150000,
            'price_cost' => 100000,
            'stock' => 10,
            'min_stock' => 5,
            'manage_stock' => true,
            'is_active' => true
        ]);

        // Create BranchStock for the product
        BranchStock::create([
            'branch_id' => $branch->id,
            'stockable_type' => Product::class,
            'stockable_id' => $product->id,
            'stock' => 10
        ]);

        Livewire::test(SalesInterface::class)
            ->call('addToCart', $product->id)
            ->set('paymentMethod', 'cheque')
            ->set('chequeDetails', [
                'bank_name' => 'Banco Test',
                'cheque_number' => 'CH-123456',
                'due_date' => now()->addDays(30)->format('Y-m-d')
            ])
            ->call('processSale')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('sales', [
            'total' => 150000,
            'payment_condition' => 'contado'
        ]);

        $sale = Sale::latest()->first();

        $this->assertDatabaseHas('payments', [
            'sale_id' => $sale->id,
            'method' => 'cheque',
            'amount' => 150000,
            'bank_name' => 'Banco Test',
            'cheque_number' => 'CH-123456',
        ]);
        
        $payment = Payment::where('sale_id', $sale->id)->first();
        $this->assertEquals('Banco Test', $payment->bank_name);
        $this->assertEquals('CH-123456', $payment->cheque_number);
    }

    public function test_cheque_details_are_required()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Setup Branch and Register
        $branch = Branch::create([
            'name' => 'Sucursal Central',
            'address' => 'Asuncion',
            'is_active' => true
        ]);

        $register = CashRegister::create([
            'name' => 'Caja Central',
            'branch_id' => $branch->id,
            'active' => true
        ]);

        CashSession::create([
            'user_id' => $user->id,
            'cash_register_id' => $register->id,
            'opened_at' => now(),
            'opening_amount' => 100000,
            'status' => 'open'
        ]);

        $product = Product::forceCreate([
            'name' => 'Producto Cheque Req',
            'sku' => 'CHEQUE-002',
            'price_sale' => 50000,
            'price_cost' => 30000,
            'stock' => 10,
            'min_stock' => 5,
            'manage_stock' => true,
            'is_active' => true
        ]);

        // Create BranchStock for the product
        BranchStock::create([
            'branch_id' => $branch->id,
            'stockable_type' => Product::class,
            'stockable_id' => $product->id,
            'stock' => 10
        ]);

        Livewire::test(SalesInterface::class)
            ->call('addToCart', $product->id)
            ->set('paymentMethod', 'cheque')
            ->set('chequeDetails', [
                'bank_name' => '', // Empty
                'cheque_number' => '', // Empty
                'due_date' => '' // Empty
            ])
            ->call('processSale')
            ->assertHasErrors(['chequeDetails.bank_name', 'chequeDetails.cheque_number', 'chequeDetails.due_date']);
    }
}
