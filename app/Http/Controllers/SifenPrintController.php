<?php

namespace App\Http\Controllers;

use App\Services\SifenService;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class SifenPrintController extends Controller
{
    /**
     * Muestra e imprime el KuDE de prueba en cinta térmica (80mm).
     */
    public function printTestTicket()
    {
        $testDoc = SifenService::generateTestDocument();
        $settings = StoreSetting::all()->pluck('value', 'key');

        return view('print.kude-test-ticket', compact('testDoc', 'settings'));
    }

    /**
     * Muestra e imprime el KuDE de prueba en formato A4 / Factura completa.
     */
    public function printTestA4()
    {
        $testDoc = SifenService::generateTestDocument();
        $settings = StoreSetting::all()->pluck('value', 'key');

        return view('print.kude-test-a4', compact('testDoc', 'settings'));
    }
}
