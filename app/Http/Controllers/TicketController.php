<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show(Sale $sale)
    {
        $sale->load(['items.product', 'user', 'customer', 'payments', 'seller']);
        
        $settings = StoreSetting::all()->pluck('value', 'key');
        
        return view('sales.ticket', compact('sale', 'settings'));
    }
}
