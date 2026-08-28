<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StoreSetting;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PricelistController extends Controller
{
    public function download()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');
        
        if (($settings->get('shop_show_pricelist', '0') !== '1')) {
            abort(404);
        }

        $shopName = $settings->get('store_name', 'ZonaShop');
        $date = now()->format('d/m/Y - H:i');
        
        $content = "┌" . str_repeat("─", 78) . "┐\n";
        $content .= "│" . str_pad(mb_strtoupper($shopName), 78, " ", STR_PAD_BOTH) . "│\n";
        $content .= "└" . str_repeat("─", 78) . "┘\n\n";
        
        $content .= "IMPORTANTE: Esta lista de precios es informativa y puede estar sujeta a\n";
        $content .= "cambios sin previo aviso. Los precios mostrados están en Guaraníes (PYG).\n";
        $content .= "Para confirmar disponibilidad y precios actuales, contacte directamente\n";
        $content .= "con la tienda.\n\n";
        
        $content .= str_repeat("-", 80) . "\n";
        $content .= "Generado: " . $date . "\n";
        $content .= str_repeat("-", 80) . "\n\n";
        
        $content .= "LISTADO DE PRODUCTOS:\n\n";
        $content .= str_pad("PRODUCTO", 65) . str_pad("PRECIO", 15, " ", STR_PAD_LEFT) . "\n";
        $content .= str_repeat("-", 80) . "\n";
 
        $products = Product::where('is_active', true)
            ->with('category')
            ->orderBy('category_id')
            ->get();

        $i = 1;
        foreach ($products as $product) {
            $number = str_pad($i, 3, "0", STR_PAD_LEFT);
            $name = mb_substr($product->name, 0, 55);
            $price = number_format($product->effective_price, 0, ',', '.') . " Gs.";
            
            // Calculate dots
            $totalLen = 80;
            $leftSide = $number . ". " . $name;
            $dotsLen = $totalLen - mb_strlen($leftSide) - mb_strlen($price);
            
            if ($dotsLen < 1) $dotsLen = 1;
            
            $content .= $leftSide . str_repeat(".", $dotsLen) . $price . "\n";
            $i++;
        }

        $filename = "Lista_de_Precios_" . Str::slug($shopName) . "_" . now()->format('Ymd') . ".txt";

        return response($content)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
