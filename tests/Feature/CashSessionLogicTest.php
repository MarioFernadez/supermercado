<?php

namespace Tests\Feature;

use App\Models\CashRegister;
use App\Models\CashSession;
use App\Models\Sale;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CashSessionLogicTest extends TestCase
{
    use RefreshDatabase;

    public function test_expected_cash_includes_only_cash_sales()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $register = CashRegister::create(['name' => 'Caja 1', 'active' => true]);

        // 1. Open Session with 100
        $session = CashSession::create([
            'user_id' => $user->id,
            'cash_register_id' => $register->id,
            'opening_amount' => 100,
            'opened_at' => now(),
            'status' => 'open'
        ]);

        // 2. Make a Cash Sale of 50
        $saleCash = Sale::create([
            'user_id' => $user->id,
            'total' => 50,
            'created_at' => now()
        ]);
        Payment::create([
            'sale_id' => $saleCash->id,
            'method' => 'efectivo',
            'amount' => 50
        ]);

        // 3. Make a Card Sale of 200
        $saleCard = Sale::create([
            'user_id' => $user->id,
            'total' => 200,
            'created_at' => now()
        ]);
        Payment::create([
            'sale_id' => $saleCard->id,
            'method' => 'tarjeta',
            'amount' => 200
        ]);

        // 4. Test logic in SessionManager
        $component = Livewire::test(\App\Livewire\Cash\SessionManager::class);
        $component->call('loadCurrentSession');

        $component
            ->assertSet('totalSales', 250) // Total Revenue
            ->assertSet('totalCashSales', 50) // Only Cash
            ->assertSeeHtml('Total Esperado en Caja')
            ->assertSeeHtml('150'); // 100 (Opening) + 50 (Cash Sale)
    }
}
