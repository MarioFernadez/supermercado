<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PrintController extends Controller
{
    /**
     * Renders the barcode labels print view
     */
    public function labels(Request $request)
    {
        $payload = $request->query('p');
        
        if (!$payload) {
            abort(400, 'Payload missing');
        }

        $data = json_decode(base64_decode($payload), true);
        
        if (!$data || !isset($data['quantities'])) {
            abort(400, 'Invalid payload');
        }

        $quantities = $data['quantities'];
        $format = $data['format'] ?? 'a4';
        $includePrice = $data['include_price'] ?? true;
        $includeName = $data['include_name'] ?? true;

        $productIds = array_keys($quantities);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Create a flat array of labels to print
        $labelsToPrint = [];
        foreach ($quantities as $productId => $qty) {
            if (isset($products[$productId])) {
                $product = $products[$productId];
                for ($i = 0; $i < $qty; $i++) {
                    $labelsToPrint[] = $product;
                }
            }
        }

        return view('print.labels', compact('labelsToPrint', 'format', 'includePrice', 'includeName'));
    }
}
