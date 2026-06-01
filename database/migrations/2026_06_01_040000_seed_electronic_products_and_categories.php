<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Category;
use App\Models\Product;
use App\Models\Branch;
use App\Models\BranchStock;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Seed 5 Electronic Categories
        $categoriesData = [
            [
                'name' => 'Smartphones & Accesorios',
                'description' => 'Celulares de última generación, protectores, cables y cargadores de carga rápida.'
            ],
            [
                'name' => 'Computadoras & Laptops',
                'description' => 'Notebooks gamers, Macs, periféricos premium, monitores y componentes de PC.'
            ],
            [
                'name' => 'Audio & Sonido',
                'description' => 'Auriculares con cancelación de ruido, parlantes Bluetooth portátiles y barras de sonido.'
            ],
            [
                'name' => 'Smart TVs & Entretenimiento',
                'description' => 'Televisores OLED, consolas de videojuegos de última generación y accesorios multimedia.'
            ],
            [
                'name' => 'Wearables & Gadgets',
                'description' => 'Relojes inteligentes, rastreadores de fitness, realidad virtual y gadgets para el hogar.'
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cData) {
            $categories[$cData['name']] = Category::firstOrCreate(
                ['name' => $cData['name']],
                [
                    'is_active' => true
                ]
            );
        }

        // 2. Fetch all branches to seed branch stocks
        $branches = Branch::all();

        // 3. Define 50 products (10 per category) with Paraguayan Guaraní prices (PYG)
        $productsData = [
            // --- Smartphones & Accesorios ---
            'Smartphones & Accesorios' => [
                [
                    'name' => 'iPhone 15 Pro Max 256GB',
                    'sku' => 'SKU-ELEC-001',
                    'description' => 'El iPhone más potente de Apple, con estructura de titanio de calidad aeroespacial y chip A17 Pro.',
                    'price_cost' => 8500000,
                    'price_sale' => 10500000,
                    'stock' => 15,
                ],
                [
                    'name' => 'Samsung Galaxy S24 Ultra 512GB',
                    'sku' => 'SKU-ELEC-002',
                    'description' => 'Flagship con Galaxy AI, cámara de 200MP y S-Pen integrado en color Titanium Gray.',
                    'price_cost' => 7800000,
                    'price_sale' => 9600000,
                    'stock' => 12,
                ],
                [
                    'name' => 'Xiaomi Redmi Note 13 Pro 256GB',
                    'sku' => 'SKU-ELEC-003',
                    'description' => 'La mejor relación calidad-precio con pantalla AMOLED de 120Hz y cámara principal de 200MP.',
                    'price_cost' => 1500000,
                    'price_sale' => 1950000,
                    'stock' => 25,
                ],
                [
                    'name' => 'Cargador Rápido Anker Nano 20W USB-C',
                    'sku' => 'SKU-ELEC-004',
                    'description' => 'Cargador ultra compacto certificado para carga rápida de smartphones Apple y Android.',
                    'price_cost' => 110000,
                    'price_sale' => 160000,
                    'stock' => 50,
                ],
                [
                    'name' => 'Cable USB-C a Lightning Anker PowerLine 1.8m',
                    'sku' => 'SKU-ELEC-005',
                    'description' => 'Cable ultra resistente con revestimiento de silicona suave y certificación MFi.',
                    'price_cost' => 60000,
                    'price_sale' => 95000,
                    'stock' => 45,
                ],
                [
                    'name' => 'Funda Ringke Fusion-X para iPhone 15 Pro',
                    'sku' => 'SKU-ELEC-006',
                    'description' => 'Protección anticaídas de grado militar con diseño camuflado y bordes reforzados.',
                    'price_cost' => 90000,
                    'price_sale' => 140000,
                    'stock' => 30,
                ],
                [
                    'name' => 'Motorola Edge 50 Pro 5G 256GB',
                    'sku' => 'SKU-ELEC-007',
                    'description' => 'Smartphone premium con cámara de nivel cinematográfico, carga TurboPower y diseño elegante.',
                    'price_cost' => 3200000,
                    'price_sale' => 4100000,
                    'stock' => 10,
                ],
                [
                    'name' => 'Powerbank Xiaomi Redmi 20000mAh 18W',
                    'sku' => 'SKU-ELEC-008',
                    'description' => 'Batería externa de alta capacidad con doble salida USB y carga rápida inteligente.',
                    'price_cost' => 180000,
                    'price_sale' => 260000,
                    'stock' => 40,
                ],
                [
                    'name' => 'Soporte Celular para Auto Baseus Metálico',
                    'sku' => 'SKU-ELEC-009',
                    'description' => 'Soporte de gravedad para rejilla de aire acondicionado hecho de aleación de aluminio pulido.',
                    'price_cost' => 50000,
                    'price_sale' => 85000,
                    'stock' => 35,
                ],
                [
                    'name' => 'Protector de Pantalla Ringke Cristal Templado (2-Pack)',
                    'sku' => 'SKU-ELEC-010',
                    'description' => 'Pack de 2 vidrios templados 9H con revestimiento oleofóbico antihuellas.',
                    'price_cost' => 40000,
                    'price_sale' => 70000,
                    'stock' => 60,
                ],
            ],

            // --- Computadoras & Laptops ---
            'Computadoras & Laptops' => [
                [
                    'name' => 'MacBook Air M2 8GB 256GB SSD',
                    'sku' => 'SKU-ELEC-011',
                    'description' => 'Pantalla Liquid Retina de 13.6 pulgadas, chip M2 súper veloz y hasta 18 horas de batería.',
                    'price_cost' => 7200000,
                    'price_sale' => 9200000,
                    'stock' => 8,
                ],
                [
                    'name' => 'Laptop ASUS ROG Zephyrus G14 Gaming',
                    'sku' => 'SKU-ELEC-012',
                    'description' => 'Laptop gamer con procesador Ryzen 9, 16GB RAM, SSD 1TB y tarjeta gráfica RTX 4060.',
                    'price_cost' => 10500000,
                    'price_sale' => 13500000,
                    'stock' => 5,
                ],
                [
                    'name' => 'Laptop HP Pavilion 15 Core i5 16GB RAM',
                    'sku' => 'SKU-ELEC-013',
                    'description' => 'Ideal para productividad y estudio, con SSD de 512GB, teclado retroiluminado y pantalla Full HD.',
                    'price_cost' => 3800000,
                    'price_sale' => 4900000,
                    'stock' => 15,
                ],
                [
                    'name' => 'Laptop Lenovo IdeaPad 3 AMD Ryzen 5',
                    'sku' => 'SKU-ELEC-014',
                    'description' => 'Gran rendimiento escolar y de oficina. 8GB RAM, SSD 256GB, ligera y de diseño delgado.',
                    'price_cost' => 2900000,
                    'price_sale' => 3800000,
                    'stock' => 20,
                ],
                [
                    'name' => 'Monitor Gamer LG UltraGear 24" 144Hz',
                    'sku' => 'SKU-ELEC-015',
                    'description' => 'Monitor gamer con tiempo de respuesta de 1ms, resolución Full HD y compatible con G-Sync.',
                    'price_cost' => 1100000,
                    'price_sale' => 1550000,
                    'stock' => 14,
                ],
                [
                    'name' => 'Mouse Inalámbrico Logitech MX Master 3S',
                    'sku' => 'SKU-ELEC-016',
                    'description' => 'El mouse definitivo para diseñadores y programadores, con scroll magnético y 8000 DPI.',
                    'price_cost' => 600000,
                    'price_sale' => 850000,
                    'stock' => 18,
                ],
                [
                    'name' => 'Teclado Mecánico Keychron K2 Wireless Blue Switches',
                    'sku' => 'SKU-ELEC-017',
                    'description' => 'Teclado mecánico retroiluminado RGB con formato compacto del 75%, ideal para Mac y Windows.',
                    'price_cost' => 550000,
                    'price_sale' => 780000,
                    'stock' => 12,
                ],
                [
                    'name' => 'Disco Sólido Interno Kingston NV2 1TB NVMe',
                    'sku' => 'SKU-ELEC-018',
                    'description' => 'SSD interno PCIe 4.0 NVMe con velocidades de lectura de hasta 3500MB/s.',
                    'price_cost' => 350000,
                    'price_sale' => 490000,
                    'stock' => 30,
                ],
                [
                    'name' => 'Memoria RAM Corsair Vengeance 16GB DDR4 3200MHz',
                    'sku' => 'SKU-ELEC-019',
                    'description' => 'Módulo de memoria RAM de alto rendimiento con disipador de aluminio negro de bajo perfil.',
                    'price_cost' => 280000,
                    'price_sale' => 390000,
                    'stock' => 28,
                ],
                [
                    'name' => 'Mochila Porta Notebook Targus Legend IQ 16"',
                    'sku' => 'SKU-ELEC-020',
                    'description' => 'Mochila super acolchada con múltiples compartimentos, correa de hombro ergonómica y salida de audio.',
                    'price_cost' => 190000,
                    'price_sale' => 290000,
                    'stock' => 22,
                ],
            ],

            // --- Audio & Sonido ---
            'Audio & Sonido' => [
                [
                    'name' => 'Auriculares Sony WH-1000XM5 ANC',
                    'sku' => 'SKU-ELEC-021',
                    'description' => 'Los mejores auriculares Over-Ear con cancelación activa de ruido líder de la industria y micrófono HD.',
                    'price_cost' => 2100000,
                    'price_sale' => 2850000,
                    'stock' => 10,
                ],
                [
                    'name' => 'Auriculares In-Ear Apple AirPods Pro Gen 2',
                    'sku' => 'SKU-ELEC-022',
                    'description' => 'Auriculares inalámbricos con chip H2, cancelación de ruido duplicada y estuche de carga MagSafe USB-C.',
                    'price_cost' => 1500000,
                    'price_sale' => 2100000,
                    'stock' => 15,
                ],
                [
                    'name' => 'Parlante Portátil JBL Flip 6 Waterproof',
                    'sku' => 'SKU-ELEC-023',
                    'description' => 'Parlante portátil a prueba de agua y polvo IP67 con sonido potente de 2 vías y hasta 12h de música.',
                    'price_cost' => 650000,
                    'price_sale' => 890000,
                    'stock' => 20,
                ],
                [
                    'name' => 'Parlante Bluetooth JBL Boombox 3',
                    'sku' => 'SKU-ELEC-024',
                    'description' => 'El parlante para fiestas definitivo con graves masivos JBL Original Pro Sound y hasta 24h de autonomía.',
                    'price_cost' => 2600000,
                    'price_sale' => 3600000,
                    'stock' => 6,
                ],
                [
                    'name' => 'Auriculares Inalámbricos Xiaomi Redmi Buds 5',
                    'sku' => 'SKU-ELEC-025',
                    'description' => 'Auriculares económicos con cancelación activa de ruido de 46dB y hasta 40 horas de batería total.',
                    'price_cost' => 140000,
                    'price_sale' => 220000,
                    'stock' => 40,
                ],
                [
                    'name' => 'Barra de Sonido Samsung HW-C450 Subwoofer',
                    'sku' => 'SKU-ELEC-026',
                    'description' => 'Barra de sonido de 2.1 canales con subwoofer inalámbrico de graves profundos y modo de sonido nocturno.',
                    'price_cost' => 1100000,
                    'price_sale' => 1590000,
                    'stock' => 8,
                ],
                [
                    'name' => 'Micrófono de Condensador HyperX QuadCast S RGB',
                    'sku' => 'SKU-ELEC-027',
                    'description' => 'Micrófono USB premium ideal para streamers y podcasters, con montura antivibración y patrones polares.',
                    'price_cost' => 800000,
                    'price_sale' => 1150000,
                    'stock' => 12,
                ],
                [
                    'name' => 'Auriculares Gamer Razer BlackShark V2 Pro',
                    'sku' => 'SKU-ELEC-028',
                    'description' => 'Auriculares para e-sports inalámbricos con audio espacial THX, diafragmas de 50mm y micrófono de banda ancha.',
                    'price_cost' => 950000,
                    'price_sale' => 1350000,
                    'stock' => 14,
                ],
                [
                    'name' => 'Parlante Inteligente Amazon Echo Dot 5ta Gen',
                    'sku' => 'SKU-ELEC-029',
                    'description' => 'El parlante inteligente con Alexa más popular, con sonido mejorado para voces nítidas y graves profundos.',
                    'price_cost' => 250000,
                    'price_sale' => 380000,
                    'stock' => 25,
                ],
                [
                    'name' => 'Receptor de Audio Bluetooth Ugreen de 3.5mm',
                    'sku' => 'SKU-ELEC-030',
                    'description' => 'Adaptador de audio inalámbrico para autorradios o equipos de sonido analógicos antiguos.',
                    'price_cost' => 80000,
                    'price_sale' => 130000,
                    'stock' => 30,
                ],
            ],

            // --- Smart TVs & Entretenimiento ---
            'Smart TVs & Entretenimiento' => [
                [
                    'name' => 'Smart TV LG OLED Evo C3 55" 4K',
                    'sku' => 'SKU-ELEC-031',
                    'description' => 'Televisor OLED con panel Evo de máxima luminosidad, procesador a9 Gen6 AI y frecuencia de 120Hz.',
                    'price_cost' => 7800000,
                    'price_sale' => 10800000,
                    'stock' => 4,
                ],
                [
                    'name' => 'Smart TV Samsung Crystal UHD 65" 4K',
                    'sku' => 'SKU-ELEC-032',
                    'description' => 'Pantalla gigante con resolución 4K real, tecnología PurColor y sistema operativo Tizen fluido.',
                    'price_cost' => 3800000,
                    'price_sale' => 4990000,
                    'stock' => 8,
                ],
                [
                    'name' => 'Smart TV Xiaomi A Pro 43" Google TV',
                    'sku' => 'SKU-ELEC-033',
                    'description' => 'Pantalla UHD 4K con Dolby Vision, bordes metálicos ultrafinos y sistema integrado Google TV.',
                    'price_cost' => 1500000,
                    'price_sale' => 1990000,
                    'stock' => 15,
                ],
                [
                    'name' => 'Consola Sony PlayStation 5 Slim 1TB',
                    'sku' => 'SKU-ELEC-034',
                    'description' => 'Consola PS5 en su versión Slim renovada con almacenamiento de 1TB de ultra alta velocidad.',
                    'price_cost' => 3500000,
                    'price_sale' => 4590000,
                    'stock' => 10,
                ],
                [
                    'name' => 'Consola Nintendo Switch OLED Edition',
                    'sku' => 'SKU-ELEC-035',
                    'description' => 'Consola portátil/híbrida con pantalla OLED de 7 pulgadas y colores vibrantes en color blanco.',
                    'price_cost' => 2100000,
                    'price_sale' => 2850000,
                    'stock' => 14,
                ],
                [
                    'name' => 'Dispositivo de Streaming Google Chromecast 4K',
                    'sku' => 'SKU-ELEC-036',
                    'description' => 'Convierte tu televisor normal en un Smart TV de alta gama con control remoto por voz de Google TV.',
                    'price_cost' => 300000,
                    'price_sale' => 440000,
                    'stock' => 35,
                ],
                [
                    'name' => 'Proyector Portátil Samsung The Freestyle Gen 2',
                    'sku' => 'SKU-ELEC-037',
                    'description' => 'Proyector portátil inteligente Full HD con parlante de 360 grados integrado y enfoque automático.',
                    'price_cost' => 3200000,
                    'price_sale' => 4600000,
                    'stock' => 5,
                ],
                [
                    'name' => 'Control Inalámbrico PS5 DualSense Blanco',
                    'sku' => 'SKU-ELEC-038',
                    'description' => 'Control inalámbrico para PlayStation 5 con retroalimentación háptica y gatillos adaptativos.',
                    'price_cost' => 420000,
                    'price_sale' => 580000,
                    'stock' => 20,
                ],
                [
                    'name' => 'Soporte de Pared para TV 32"-70" Articulado',
                    'sku' => 'SKU-ELEC-039',
                    'description' => 'Soporte metálico super reforzado de doble brazo articulado con inclinación y giro.',
                    'price_cost' => 120000,
                    'price_sale' => 190000,
                    'stock' => 30,
                ],
                [
                    'name' => 'Cable HDMI 2.1 Ugreen Ultra High Speed 2m',
                    'sku' => 'SKU-ELEC-040',
                    'description' => 'Cable HDMI 8K a 60Hz o 4K a 120Hz con blindaje trenzado y conectores chapados en oro.',
                    'price_cost' => 70000,
                    'price_sale' => 110000,
                    'stock' => 40,
                ],
            ],

            // --- Wearables & Gadgets ---
            'Wearables & Gadgets' => [
                [
                    'name' => 'Apple Watch Series 9 GPS 45mm',
                    'sku' => 'SKU-ELEC-041',
                    'description' => 'Smartwatch premium con chip S9, pantalla Always-On super brillante y control por doble toque.',
                    'price_cost' => 3200000,
                    'price_sale' => 4250000,
                    'stock' => 8,
                ],
                [
                    'name' => 'Samsung Galaxy Watch 6 44mm BT',
                    'sku' => 'SKU-ELEC-042',
                    'description' => 'Monitoreo de composición corporal, sensor de temperatura y análisis avanzado del sueño en color negro.',
                    'price_cost' => 1600000,
                    'price_sale' => 2290000,
                    'stock' => 10,
                ],
                [
                    'name' => 'Xiaomi Smart Band 8 Active Black',
                    'sku' => 'SKU-ELEC-043',
                    'description' => 'Pulsera de actividad física con pantalla de alta tasa de refresco y hasta 16 días de duración de batería.',
                    'price_cost' => 180000,
                    'price_sale' => 270000,
                    'stock' => 35,
                ],
                [
                    'name' => 'Garmin Fenix 7 Pro Sapphire Solar',
                    'sku' => 'SKU-ELEC-044',
                    'description' => 'Reloj multideporte GPS ultra premium con lente de carga solar, linterna LED y mapas topo.',
                    'price_cost' => 5200000,
                    'price_sale' => 6950000,
                    'stock' => 4,
                ],
                [
                    'name' => 'Lente de Realidad Virtual Meta Quest 3 128GB',
                    'sku' => 'SKU-ELEC-045',
                    'description' => 'El dispositivo de realidad mixta definitivo, sin necesidad de cables ni computadoras externas.',
                    'price_cost' => 4100000,
                    'price_sale' => 5600000,
                    'stock' => 6,
                ],
                [
                    'name' => 'Localizador Inteligente Apple AirTag (1-Pack)',
                    'sku' => 'SKU-ELEC-046',
                    'description' => 'Encuentra tus llaves, mochilas y objetos perdidos a través de la aplicación Encontrar en iOS.',
                    'price_cost' => 200000,
                    'price_sale' => 290000,
                    'stock' => 50,
                ],
                [
                    'name' => 'Aro de Luz Led Baseus 10" con Trípode',
                    'sku' => 'SKU-ELEC-047',
                    'description' => 'Aro de luz ideal para videollamadas, contenido en redes sociales y maquillaje con 3 modos de color.',
                    'price_cost' => 90000,
                    'price_sale' => 150000,
                    'stock' => 20,
                ],
                [
                    'name' => 'Estabilizador de Cardán DJI Osmo Mobile 6',
                    'sku' => 'SKU-ELEC-048',
                    'description' => 'Gimbal de tres ejes para smartphones, con brazo extensible integrado y seguimiento inteligente ActiveTrack 6.0.',
                    'price_cost' => 850000,
                    'price_sale' => 1250000,
                    'stock' => 12,
                ],
                [
                    'name' => 'Enchufe Inteligente TP-Link Tapo P100 Wi-Fi',
                    'sku' => 'SKU-ELEC-049',
                    'description' => 'Enchufe inteligente programable compatible con Alexa y Google Assistant para domótica básica.',
                    'price_cost' => 60000,
                    'price_sale' => 95000,
                    'stock' => 30,
                ],
                [
                    'name' => 'Balanza Corporal Inteligente Xiaomi Body Composition 2',
                    'sku' => 'SKU-ELEC-050',
                    'description' => 'Mide con precisión 13 métricas corporales distintas como grasa, músculo, agua y masa ósea.',
                    'price_cost' => 130000,
                    'price_sale' => 195000,
                    'stock' => 18,
                ],
            ],
        ];

        // 4. Insert each product and its corresponding BranchStock records
        foreach ($productsData as $catName => $products) {
            $category = $categories[$catName];

            foreach ($products as $pData) {
                $product = Product::create([
                    'name' => $pData['name'],
                    'sku' => $pData['sku'],
                    'description' => $pData['description'],
                    'price_cost' => $pData['price_cost'],
                    'price_sale' => $pData['price_sale'],
                    'discount_percentage' => 0,
                    'stock' => $pData['stock'],
                    'min_stock' => 3,
                    'category_id' => $category->id,
                    'is_active' => true,
                    'unit_type' => 'UNIDAD',
                    'manage_stock' => true,
                    'has_variations' => false,
                ]);

                // Create branch stock entry for this product in every sucursal
                foreach ($branches as $branch) {
                    BranchStock::create([
                        'branch_id' => $branch->id,
                        'stockable_id' => $product->id,
                        'stockable_type' => Product::class,
                        'stock' => $pData['stock'],
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Delete all seeded products
        $skus = [];
        for ($i = 1; $i <= 50; $i++) {
            $skus[] = sprintf('SKU-ELEC-%03d', $i);
        }

        $products = Product::whereIn('sku', $skus)->get();
        foreach ($products as $product) {
            // Delete branch stocks first
            BranchStock::where('stockable_id', $product->id)
                ->where('stockable_type', Product::class)
                ->delete();
            
            $product->delete();
        }

        // 2. Delete the seeded categories if they are empty
        $categoryNames = [
            'Smartphones & Accesorios',
            'Computadoras & Laptops',
            'Audio & Sonido',
            'Smart TVs & Entretenimiento',
            'Wearables & Gadgets',
        ];

        Category::whereIn('name', $categoryNames)->each(function ($category) {
            if ($category->products()->count() === 0) {
                $category->delete();
            }
        });
    }
};
