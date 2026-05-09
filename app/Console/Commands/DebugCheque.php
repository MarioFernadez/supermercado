<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DebugCheque extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:debug-cheque';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug cheque payment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info("Creating User...");
            $user = \App\Models\User::first();
            if (!$user) {
                $user = \App\Models\User::factory()->create();
            }
            auth()->login($user);

            $this->info("Creating Session...");
            $session = \App\Models\CashSession::where('user_id', $user->id)->where('status', 'open')->first();
            if (!$session) {
                \App\Models\CashSession::create([
                    'user_id' => $user->id,
                    'opened_at' => now(),
                    'opening_amount' => 100000,
                    'status' => 'open'
                ]);
            }

            $this->info("Creating Product...");
            $product = \App\Models\Product::forceCreate([
                'name' => 'Producto Debug Cheque',
                'sku' => 'DEBUG-CHEQUE-' . rand(1000, 9999),
                'price_sale' => 150000,
                'price_cost' => 100000,
                'stock' => 10,
                'manage_stock' => true,
                'is_active' => true
            ]);

            $this->info("Simulating Livewire...");
            $component = \Livewire\Livewire::test(\App\Livewire\Pos\SalesInterface::class);
            
            $this->info("Adding to Cart...");
            $component->call('addToCart', $product->id);
            
            $this->info("Setting Payment Method...");
            $component->set('paymentMethod', 'cheque');
            
            $this->info("Setting Cheque Details...");
            $component->set('chequeDetails', [
                'bank_name' => 'Banco Debug',
                'cheque_number' => 'DBG-999',
                'due_date' => now()->addDays(30)->format('Y-m-d')
            ]);
            
            $this->info("Processing Sale...");
            $component->call('processSale');
            
            $this->info("Checking Database...");
            $sale = \App\Models\Sale::latest()->first();
            if ($sale) {
                $this->info("Sale created: " . $sale->id);
                $payment = \App\Models\Payment::where('sale_id', $sale->id)->first();
                if ($payment) {
                    $this->info("Payment created: " . $payment->method);
                    $this->info("Bank: " . $payment->bank_name);
                } else {
                    $this->error("Payment NOT found!");
                }
            } else {
                $this->error("Sale NOT found!");
            }

        } catch (\Throwable $e) {
            $this->error("EXCEPTION: " . $e->getMessage());
            file_put_contents('error_log.txt', $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }
}
