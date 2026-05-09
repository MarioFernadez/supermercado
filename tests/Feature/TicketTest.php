<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sale;
use App\Models\Payment;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_shows_payment_details()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create Sale
        $sale = Sale::create([
            'user_id' => $user->id,
            'total' => 100000,
            'tax_10' => 9091,
            'tax_5' => 0,
            'tax_exempt' => 0,
            'status' => 'completed',
            'payment_condition' => 'contado'
        ]);

        // Create Payments
        Payment::create([
            'sale_id' => $sale->id,
            'method' => 'efectivo',
            'amount' => 50000
        ]);

        Payment::create([
            'sale_id' => $sale->id,
            'method' => 'tarjeta',
            'amount' => 50000
        ]);

        // Create Items (needed for ticket view)
        $product = Product::forceCreate([
            'name' => 'Producto Test',
            'sku' => 'TEST-001',
            'price_sale' => 100000,
            // 'cost' => 50000, // Removed incorrect column
            'stock' => 10,
            'min_stock' => 5,
            'manage_stock' => true,
            'is_active' => true,
            'unit_type' => 'unit',
            'price_cost' => 50000
        ]);

        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => 1,
            'price_unit' => 100000,
            'subtotal' => 100000
        ]);

        // Request Ticket
        $response = $this->get(route('sales.ticket', $sale));

        $response->assertStatus(200);
        $response->assertSee('Ticket #');
        $response->assertSee('Pagos:');
        $response->assertSee('Efectivo:');
        $response->assertSee('Tarjeta:');
        $response->assertSee('50.000');
    }
}
