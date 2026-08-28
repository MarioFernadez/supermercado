<?php

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// --- 1. Move Images and Create Banners ---
$storagePath = storage_path('app/public/banners');
if (!File::exists($storagePath)) {
    File::makeDirectory($storagePath, 0755, true);
}

// These are placeholders for the paths found in the conversation.
// I will use some logic to find the files in the brain directory if possible, 
// but since I'm running this on the user's machine, I'll use the absolute paths provided.
$image1 = 'C:\Users\sotew\.gemini\antigravity\brain\37aefd07-75f1-4970-8691-2fb356edd82e\carousel_banner_1_1774729096751.png';
$image2 = 'C:\Users\sotew\.gemini\antigravity\brain\37aefd07-75f1-4970-8691-2fb356edd82e\carousel_banner_2_1774729110313.png';

$dest1 = 'banners/banner_1.png';
$dest2 = 'banners/banner_2.png';

if (File::exists($image1)) {
    File::copy($image1, storage_path('app/public/' . $dest1));
    Banner::updateOrCreate(
        ['title' => 'Tecnología de Vanguardia'],
        [
            'subtitle' => 'Descubre lo último en gadgets y electrónica',
            'image_path' => $dest1,
            'is_active' => true,
            'order' => 1
        ]
    );
    echo "Banner 1 created.\n";
} else {
    echo "Image 1 not found at $image1\n";
}

if (File::exists($image2)) {
    File::copy($image2, storage_path('app/public/' . $dest2));
    Banner::updateOrCreate(
        ['title' => 'Estilo y Bienestar'],
        [
            'subtitle' => 'Colección exclusiva para un estilo de vida premium',
            'image_path' => $dest2,
            'is_active' => true,
            'order' => 2
        ]
    );
    echo "Banner 2 created.\n";
} else {
    echo "Image 2 not found at $image2\n";
}

// --- 2. Create 3 'Tiendas' (as Categories) and 10 products each ---
$stores = [
    'Tech Store Elite' => [
        'prefix' => 'TSE',
        'products' => [
            'Smartphone Pro Max', 'Laptop Ultra Thin', 'Auriculares Noise Cancelling',
            'Tablet Creative 12', 'Monitor Gaming 4K', 'Teclado Mecánico RGB',
            'Mouse Inalámbrico Ergo', 'Smartwatch Fit Pro', 'Cámara Mirrorless 4K',
            'Parlante Bluetooth Hi-Fi'
        ]
    ],
    'Fashion Hub' => [
        'prefix' => 'FH',
        'products' => [
            'Camisa de Lino Premium', 'Jeans Slim Fit', 'Vestido Floral Verano',
            'Zapatillas Classic White', 'Reloj Analógico Elegant', 'Bolso de Cuero Hecho a Mano',
            'Sombrero Panama Style', 'Gafas de Sol Polarizadas', 'Bufanda de Cachemira',
            'Cinturón Minimalista'
        ]
    ],
    'Home & Deco' => [
        'prefix' => 'HD',
        'products' => [
            'Sillón Velvet Comfort', 'Lámpara de Pie Moderna', 'Mesa de Centro Roble',
            'Juego de Sábanas Algodón', 'Cafetera Espresso Pro', 'Set de Cubertería Inox',
            'Espejo de Pared Dorado', 'Difusor de Aromas Zen', 'Alfombra Geométrica',
            'Macetero Cerámica Minimal'
        ]
    ]
];

foreach ($stores as $storeName => $data) {
    $category = Category::updateOrCreate(
        ['name' => $storeName],
        ['is_active' => true]
    );

    echo "Category/Store '$storeName' created.\n";

    foreach ($data['products'] as $index => $prodName) {
        Product::updateOrCreate(
            ['sku' => $data['prefix'] . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT)],
            [
                'name' => $prodName,
                'price_sale' => rand(50000, 5000000),
                'price_cost' => rand(40000, 4000000),
                'stock' => rand(5, 50),
                'min_stock' => 2,
                'category_id' => $category->id,
                'is_active' => true,
                'manage_stock' => true,
                'description' => 'Descripción corta para ' . $prodName . ' de la tienda ' . $storeName,
                'unit_type' => 'UNIDAD',
            ]
        );
    }
    echo "10 products added to '$storeName'.\n";
}

echo "Done!\n";
