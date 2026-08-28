<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Branch;
use App\Models\BranchStock;
use Illuminate\Support\Str;

class MinimarketProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = Branch::first();
        if (!$branch) {
            $branch = Branch::create([
                'name' => 'Casa Central - Asunción',
                'address' => 'Avda. Eusebio Ayala 1234',
                'phone' => '021 555 1234',
                'is_active' => true,
            ]);
        }

        $catalog = [
            // =========================================================================
            // 1. CARNICERÍA, CORTES Y EMBUTIDOS (45 items)
            // =========================================================================
            'Carnicería y Embutidos' => [
                // Materias Primas para Taller de Desposte
                ['name' => 'Media Res Vacuna', 'sku' => 'MAT-RES-01', 'unit' => 'kg', 'cost' => 22000, 'sale' => 26000, 'stock' => 350.0, 'raw' => true, 'zone' => 'kitchen'],
                ['name' => 'Cerdo Entero Faenado', 'sku' => 'MAT-CER-01', 'unit' => 'kg', 'cost' => 18000, 'sale' => 22000, 'stock' => 180.0, 'raw' => true, 'zone' => 'kitchen'],
                ['name' => 'Cordero Entero', 'sku' => 'MAT-COR-01', 'unit' => 'kg', 'cost' => 32000, 'sale' => 38000, 'stock' => 60.0, 'raw' => true, 'zone' => 'kitchen'],

                // Cortes Vacunos Tradicionales de Paraguay (en kg)
                ['name' => 'Costilla de Primera Vacuna', 'sku' => 'CAR-COS-01', 'unit' => 'kg', 'cost' => 28000, 'sale' => 38500, 'stock' => 45.0, 'zone' => 'kitchen'],
                ['name' => 'Tapa Cuadril / Picaña', 'sku' => 'CAR-PIC-01', 'unit' => 'kg', 'cost' => 45000, 'sale' => 62000, 'stock' => 25.0, 'zone' => 'kitchen'],
                ['name' => 'Vacío Vacuno', 'sku' => 'CAR-VAC-01', 'unit' => 'kg', 'cost' => 32000, 'sale' => 44000, 'stock' => 35.0, 'zone' => 'kitchen'],
                ['name' => 'Lomito Vacuno', 'sku' => 'CAR-LOM-01', 'unit' => 'kg', 'cost' => 52000, 'sale' => 69000, 'stock' => 18.0, 'zone' => 'kitchen'],
                ['name' => 'Colita de Cuadril', 'sku' => 'CAR-COL-01', 'unit' => 'kg', 'cost' => 38000, 'sale' => 49500, 'stock' => 20.0, 'zone' => 'kitchen'],
                ['name' => 'Carnaza Negra Especial', 'sku' => 'CAR-NEG-01', 'unit' => 'kg', 'cost' => 31000, 'sale' => 42000, 'stock' => 40.0, 'zone' => 'kitchen'],
                ['name' => 'Carnaza Blanca', 'sku' => 'CAR-BLA-01', 'unit' => 'kg', 'cost' => 29000, 'sale' => 39000, 'stock' => 35.0, 'zone' => 'kitchen'],
                ['name' => 'Peceto Vacuno', 'sku' => 'CAR-PEC-01', 'unit' => 'kg', 'cost' => 36000, 'sale' => 47000, 'stock' => 22.0, 'zone' => 'kitchen'],
                ['name' => 'Bola de Lomo', 'sku' => 'CAR-BOL-01', 'unit' => 'kg', 'cost' => 30000, 'sale' => 41000, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Puchero Especial con Carne', 'sku' => 'CAR-PUC-01', 'unit' => 'kg', 'cost' => 11000, 'sale' => 16500, 'stock' => 50.0, 'zone' => 'kitchen'],
                ['name' => 'Puchero de Segunda', 'sku' => 'CAR-PUC-02', 'unit' => 'kg', 'cost' => 6000, 'sale' => 9500, 'stock' => 60.0, 'zone' => 'kitchen'],
                ['name' => 'Matambre Vacuno', 'sku' => 'CAR-MAT-01', 'unit' => 'kg', 'cost' => 30000, 'sale' => 43000, 'stock' => 15.0, 'zone' => 'kitchen'],
                ['name' => 'Falda Vacuna', 'sku' => 'CAR-FAL-01', 'unit' => 'kg', 'cost' => 22000, 'sale' => 29500, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Carne Molida de Primera', 'sku' => 'CAR-MOL-01', 'unit' => 'kg', 'cost' => 31000, 'sale' => 42000, 'stock' => 35.0, 'zone' => 'kitchen'],
                ['name' => 'Carne Molida Común', 'sku' => 'CAR-MOL-02', 'unit' => 'kg', 'cost' => 20000, 'sale' => 28000, 'stock' => 40.0, 'zone' => 'kitchen'],
                ['name' => 'Costilla Ancha', 'sku' => 'CAR-COS-02', 'unit' => 'kg', 'cost' => 26000, 'sale' => 35000, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Osobuco Vacuno', 'sku' => 'CAR-OSO-01', 'unit' => 'kg', 'cost' => 18000, 'sale' => 25000, 'stock' => 25.0, 'zone' => 'kitchen'],
                ['name' => 'Aguja Vacuna', 'sku' => 'CAR-AGU-01', 'unit' => 'kg', 'cost' => 21000, 'sale' => 28500, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Hueso Blanco para Caldo', 'sku' => 'CAR-HUE-01', 'unit' => 'kg', 'cost' => 2000, 'sale' => 4500, 'stock' => 50.0, 'zone' => 'kitchen'],
                ['name' => 'Hueso con Carne', 'sku' => 'CAR-HUE-02', 'unit' => 'kg', 'cost' => 4500, 'sale' => 7500, 'stock' => 40.0, 'zone' => 'kitchen'],
                ['name' => 'Grasa / Gordura Vacuna', 'sku' => 'CAR-GRA-01', 'unit' => 'kg', 'cost' => 4000, 'sale' => 7500, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Hígado Vacuno', 'sku' => 'CAR-ACH-01', 'unit' => 'kg', 'cost' => 12000, 'sale' => 17500, 'stock' => 20.0, 'zone' => 'kitchen'],
                ['name' => 'Mondongo Vacuno Limpio', 'sku' => 'CAR-ACH-02', 'unit' => 'kg', 'cost' => 16000, 'sale' => 23000, 'stock' => 15.0, 'zone' => 'kitchen'],
                ['name' => 'Lengua Vacuna', 'sku' => 'CAR-ACH-03', 'unit' => 'kg', 'cost' => 24000, 'sale' => 34000, 'stock' => 12.0, 'zone' => 'kitchen'],
                ['name' => 'Corazón Vacuno', 'sku' => 'CAR-ACH-04', 'unit' => 'kg', 'cost' => 10000, 'sale' => 15000, 'stock' => 15.0, 'zone' => 'kitchen'],
                ['name' => 'Rincón / Riñón Vacuno', 'sku' => 'CAR-ACH-05', 'unit' => 'kg', 'cost' => 8000, 'sale' => 13000, 'stock' => 15.0, 'zone' => 'kitchen'],
                ['name' => 'Chinchulines Vacunos', 'sku' => 'CAR-ACH-06', 'unit' => 'kg', 'cost' => 11000, 'sale' => 16500, 'stock' => 20.0, 'zone' => 'kitchen'],

                // Pollo y Cerdo
                ['name' => 'Pechuga de Pollo Pechugon', 'sku' => 'POL-PEC-01', 'unit' => 'kg', 'cost' => 17000, 'sale' => 24500, 'stock' => 40.0, 'zone' => 'kitchen'],
                ['name' => 'Muslo de Pollo Pollpar', 'sku' => 'POL-MUS-01', 'unit' => 'kg', 'cost' => 11500, 'sale' => 16500, 'stock' => 60.0, 'zone' => 'kitchen'],
                ['name' => 'Alitas de Pollo Pechugon', 'sku' => 'POL-ALI-01', 'unit' => 'kg', 'cost' => 13000, 'sale' => 18900, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Pollo Entero Faenado', 'sku' => 'POL-ENT-01', 'unit' => 'kg', 'cost' => 10500, 'sale' => 14500, 'stock' => 50.0, 'zone' => 'kitchen'],
                ['name' => 'Menudencias de Pollo', 'sku' => 'POL-MEN-01', 'unit' => 'kg', 'cost' => 5000, 'sale' => 8000, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Costillita de Cerdo', 'sku' => 'CER-COS-01', 'unit' => 'kg', 'cost' => 24000, 'sale' => 33000, 'stock' => 35.0, 'zone' => 'kitchen'],
                ['name' => 'Bondiola de Cerdo', 'sku' => 'CER-BON-01', 'unit' => 'kg', 'cost' => 26000, 'sale' => 36500, 'stock' => 25.0, 'zone' => 'kitchen'],
                ['name' => 'Puchero de Cerdo', 'sku' => 'CER-PUC-01', 'unit' => 'kg', 'cost' => 9000, 'sale' => 13500, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Panceta de Cerdo', 'sku' => 'CER-PAN-01', 'unit' => 'kg', 'cost' => 25000, 'sale' => 35000, 'stock' => 20.0, 'zone' => 'kitchen'],
                ['name' => 'Lomito de Cerdo', 'sku' => 'CER-LOM-01', 'unit' => 'kg', 'cost' => 27000, 'sale' => 37000, 'stock' => 20.0, 'zone' => 'kitchen'],
                ['name' => 'Pernil de Cerdo', 'sku' => 'CER-PER-01', 'unit' => 'kg', 'cost' => 19000, 'sale' => 26500, 'stock' => 30.0, 'zone' => 'kitchen'],

                // Embutidos
                ['name' => 'Chorizo Parrillero Ochsi', 'sku' => 'EMB-OCH-01', 'unit' => 'kg', 'cost' => 26000, 'sale' => 36000, 'stock' => 40.0, 'zone' => 'kitchen'],
                ['name' => 'Chorizo de Viena Ochsi 500g', 'sku' => '7840047000123', 'unit' => 'unit', 'cost' => 14000, 'sale' => 19500, 'stock' => 35.0, 'zone' => 'kitchen'],
                ['name' => 'Chorizo Picante Franz', 'sku' => 'EMB-FRZ-01', 'unit' => 'kg', 'cost' => 28000, 'sale' => 38000, 'stock' => 25.0, 'zone' => 'kitchen'],
                ['name' => 'Chorizo Tosscano Chortitzer', 'sku' => 'EMB-CHO-01', 'unit' => 'kg', 'cost' => 29000, 'sale' => 39500, 'stock' => 20.0, 'zone' => 'kitchen'],
                ['name' => 'Morcilla Criolla Ochsi', 'sku' => 'EMB-OCH-02', 'unit' => 'kg', 'cost' => 19000, 'sale' => 27000, 'stock' => 15.0, 'zone' => 'kitchen'],
                ['name' => 'Butifarra Casera San Juan', 'sku' => 'EMB-BUT-01', 'unit' => 'kg', 'cost' => 22000, 'sale' => 31000, 'stock' => 15.0, 'zone' => 'kitchen'],
                ['name' => 'Salchichas Tipo Viena Franz 6u', 'sku' => '7840058000456', 'unit' => 'unit', 'cost' => 6500, 'sale' => 9500, 'stock' => 45.0, 'zone' => 'kitchen'],
                ['name' => 'Salame Milán Ochsi Feteado 150g', 'sku' => '7840047000987', 'unit' => 'unit', 'cost' => 11000, 'sale' => 15500, 'stock' => 25.0, 'zone' => 'kitchen'],
                ['name' => 'Jamón Cocido Ochsi Feteado 200g', 'sku' => '7840047000789', 'unit' => 'unit', 'cost' => 10500, 'sale' => 14900, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Jamón Crudo Tipo Serrano 100g', 'sku' => '7840047000895', 'unit' => 'unit', 'cost' => 16000, 'sale' => 23000, 'stock' => 20.0, 'zone' => 'kitchen'],
                ['name' => 'Panceta Ahumada Feteada 150g', 'sku' => '7840047000659', 'unit' => 'unit', 'cost' => 13500, 'sale' => 18900, 'stock' => 25.0, 'zone' => 'kitchen'],
            ],

            // =========================================================================
            // 2. LÁCTEOS, QUESOS Y HUEVOS (30 items)
            // =========================================================================
            'Lácteos, Quesos y Huevos' => [
                ['name' => 'Leche Entera Trébol Sachet 1L', 'sku' => '7840011001015', 'unit' => 'unit', 'cost' => 4800, 'sale' => 6200, 'stock' => 120.0],
                ['name' => 'Leche Descremada Trébol Cartón 1L', 'sku' => '7840011001022', 'unit' => 'unit', 'cost' => 5400, 'sale' => 7000, 'stock' => 80.0],
                ['name' => 'Leche Los Colonos Entera UHT 1L', 'sku' => '7840022002011', 'unit' => 'unit', 'cost' => 5200, 'sale' => 6800, 'stock' => 90.0],
                ['name' => 'Leche Sin Lactosa Trébol Cartón 1L', 'sku' => '7840011001039', 'unit' => 'unit', 'cost' => 5800, 'sale' => 7600, 'stock' => 60.0],
                ['name' => 'Leche Chocolatada Trébol 200ml', 'sku' => '7840011001046', 'unit' => 'unit', 'cost' => 2600, 'sale' => 3800, 'stock' => 100.0, 'zone' => 'bar'],
                ['name' => 'Leche Chocolatada Trébol Cartón 1L', 'sku' => '7840011001053', 'unit' => 'unit', 'cost' => 7200, 'sale' => 9800, 'stock' => 50.0, 'zone' => 'bar'],
                ['name' => 'Leche en Polvo Trébol Entera 400g', 'sku' => '7840011001060', 'unit' => 'unit', 'cost' => 16500, 'sale' => 23500, 'stock' => 40.0],
                ['name' => 'Leche Condensada Nestlé 395g', 'sku' => '7613035401016', 'unit' => 'unit', 'cost' => 9500, 'sale' => 13800, 'stock' => 45.0],
                ['name' => 'Yogurt Frutilla Trébol Sachet 1L', 'sku' => '7840011002012', 'unit' => 'unit', 'cost' => 6200, 'sale' => 8500, 'stock' => 40.0],
                ['name' => 'Yogurt Vainilla Trébol Sachet 1L', 'sku' => '7840011002029', 'unit' => 'unit', 'cost' => 6200, 'sale' => 8500, 'stock' => 40.0],
                ['name' => 'Yogurt Griego Lactolanda Frutilla 150g', 'sku' => '7840033003017', 'unit' => 'unit', 'cost' => 4200, 'sale' => 5900, 'stock' => 35.0],
                ['name' => 'Yogurt Descremado Los Colonos Durazno 1L', 'sku' => '7840022002035', 'unit' => 'unit', 'cost' => 6800, 'sale' => 9200, 'stock' => 30.0],
                ['name' => 'Yogurt Chiki Bebible Frutilla 160g', 'sku' => '7840011002043', 'unit' => 'unit', 'cost' => 2500, 'sale' => 3600, 'stock' => 60.0],
                ['name' => 'Queso Paraguay Artesanal Tradicional', 'sku' => 'LAC-QPA-01', 'unit' => 'kg', 'cost' => 24000, 'sale' => 33000, 'stock' => 50.0],
                ['name' => 'Queso Muzzarella Trébol Barra', 'sku' => 'LAC-MUZ-01', 'unit' => 'kg', 'cost' => 33000, 'sale' => 45000, 'stock' => 40.0],
                ['name' => 'Queso Sandwich Trébol Feteado 200g', 'sku' => '7840011003019', 'unit' => 'unit', 'cost' => 9200, 'sale' => 12800, 'stock' => 45.0],
                ['name' => 'Queso Cuartirolo Los Colonos', 'sku' => 'LAC-CUA-01', 'unit' => 'kg', 'cost' => 31000, 'sale' => 42000, 'stock' => 25.0],
                ['name' => 'Queso Cheddar Feteado 150g', 'sku' => '7840011003040', 'unit' => 'unit', 'cost' => 8500, 'sale' => 11900, 'stock' => 30.0],
                ['name' => 'Queso Ricotta Trébol 500g', 'sku' => '7840011003057', 'unit' => 'unit', 'cost' => 9800, 'sale' => 13900, 'stock' => 20.0],
                ['name' => 'Queso Rallado Trébol Sobre 40g', 'sku' => '7840011003026', 'unit' => 'unit', 'cost' => 3100, 'sale' => 4600, 'stock' => 80.0],
                ['name' => 'Queso Rallado Parmesano Los Colonos 100g', 'sku' => '7840022003025', 'unit' => 'unit', 'cost' => 7800, 'sale' => 11000, 'stock' => 40.0],
                ['name' => 'Queso Untable Trébol Tradicional 200g', 'sku' => '7840011003033', 'unit' => 'unit', 'cost' => 6800, 'sale' => 9500, 'stock' => 30.0],
                ['name' => 'Manteca Trébol con Sal 200g', 'sku' => '7840011004016', 'unit' => 'unit', 'cost' => 7500, 'sale' => 10500, 'stock' => 50.0],
                ['name' => 'Manteca Trébol sin Sal 200g', 'sku' => '7840011004023', 'unit' => 'unit', 'cost' => 7500, 'sale' => 10500, 'stock' => 35.0],
                ['name' => 'Margarina Deline 250g', 'sku' => '7840011004030', 'unit' => 'unit', 'cost' => 4200, 'sale' => 6200, 'stock' => 40.0],
                ['name' => 'Crema de Leche Trébol UHT 200ml', 'sku' => '7840011005013', 'unit' => 'unit', 'cost' => 4200, 'sale' => 5900, 'stock' => 60.0],
                ['name' => 'Dulce de Leche Trébol Pote 400g', 'sku' => '7840011006010', 'unit' => 'unit', 'cost' => 8200, 'sale' => 11800, 'stock' => 45.0],
                ['name' => 'Huevos Blancos Granja Cartón 30u', 'sku' => '7840099000301', 'unit' => 'unit', 'cost' => 21000, 'sale' => 28000, 'stock' => 40.0],
                ['name' => 'Huevos Rojos Seleccionados Docena 12u', 'sku' => '7840099000127', 'unit' => 'unit', 'cost' => 9500, 'sale' => 13500, 'stock' => 50.0],
                ['name' => 'Huevos Blancos Media Docena 6u', 'sku' => '7840099000066', 'unit' => 'unit', 'cost' => 5200, 'sale' => 7500, 'stock' => 40.0],
            ],

            // =========================================================================
            // 3. BEBIDAS, GASEOSAS Y CERVEZAS (45 items)
            // =========================================================================
            'Bebidas, Gaseosas y Cervezas' => [
                // Gaseosas
                ['name' => 'Coca Cola Sabor Original 2L', 'sku' => '7840001001018', 'unit' => 'unit', 'cost' => 9000, 'sale' => 12500, 'stock' => 100.0, 'zone' => 'bar'],
                ['name' => 'Coca Cola Sabor Original 3L', 'sku' => '7840001001063', 'unit' => 'unit', 'cost' => 12000, 'sale' => 16500, 'stock' => 50.0, 'zone' => 'bar'],
                ['name' => 'Coca Cola Sabor Original 500ml', 'sku' => '7840001001070', 'unit' => 'unit', 'cost' => 4200, 'sale' => 6000, 'stock' => 90.0, 'zone' => 'bar'],
                ['name' => 'Coca Cola Sin Azúcar 2L', 'sku' => '7840001001025', 'unit' => 'unit', 'cost' => 9000, 'sale' => 12500, 'stock' => 60.0, 'zone' => 'bar'],
                ['name' => 'Coca Cola Retornable Vidrio 2L', 'sku' => '7840001001032', 'unit' => 'unit', 'cost' => 6500, 'sale' => 9000, 'stock' => 50.0, 'zone' => 'bar'],
                ['name' => 'Coca Cola Lata 350ml', 'sku' => '7840001001049', 'unit' => 'unit', 'cost' => 3400, 'sale' => 5000, 'stock' => 120.0, 'zone' => 'bar'],
                ['name' => 'Sprite Lima Limón 2L', 'sku' => '7840001002015', 'unit' => 'unit', 'cost' => 8800, 'sale' => 12000, 'stock' => 40.0, 'zone' => 'bar'],
                ['name' => 'Sprite Lima Limón Lata 350ml', 'sku' => '7840001002022', 'unit' => 'unit', 'cost' => 3400, 'sale' => 5000, 'stock' => 60.0, 'zone' => 'bar'],
                ['name' => 'Fanta Naranja 2L', 'sku' => '7840001003012', 'unit' => 'unit', 'cost' => 8800, 'sale' => 12000, 'stock' => 50.0, 'zone' => 'bar'],
                ['name' => 'Fanta Guaraná 2L', 'sku' => '7840001003029', 'unit' => 'unit', 'cost' => 8800, 'sale' => 12000, 'stock' => 35.0, 'zone' => 'bar'],
                ['name' => 'Gaseosa Pulp Naranja 2L', 'sku' => '7840005001014', 'unit' => 'unit', 'cost' => 7000, 'sale' => 9900, 'stock' => 60.0, 'zone' => 'bar'],
                ['name' => 'Gaseosa Pulp Pomelo 1.5L', 'sku' => '7840005001021', 'unit' => 'unit', 'cost' => 6200, 'sale' => 8900, 'stock' => 50.0, 'zone' => 'bar'],
                ['name' => 'Gaseosa Pulp Guaraná 2L', 'sku' => '7840005001038', 'unit' => 'unit', 'cost' => 7000, 'sale' => 9900, 'stock' => 55.0, 'zone' => 'bar'],
                ['name' => 'Gaseosa Pulp Piña 2L', 'sku' => '7840005001045', 'unit' => 'unit', 'cost' => 7000, 'sale' => 9900, 'stock' => 40.0, 'zone' => 'bar'],
                ['name' => 'Gaseosa Niko Guaraná 2L', 'sku' => '7840006001013', 'unit' => 'unit', 'cost' => 5000, 'sale' => 7500, 'stock' => 60.0, 'zone' => 'bar'],
                ['name' => 'Gaseosa Pepsi Cola 2L', 'sku' => '7840007001012', 'unit' => 'unit', 'cost' => 7800, 'sale' => 11000, 'stock' => 45.0, 'zone' => 'bar'],
                ['name' => 'Paso de los Toros Pomelo 1.5L', 'sku' => '7840007001029', 'unit' => 'unit', 'cost' => 6800, 'sale' => 9500, 'stock' => 30.0, 'zone' => 'bar'],

                // Cervezas
                ['name' => 'Cerveza Pilsen Botella 940ml', 'sku' => '7840008001011', 'unit' => 'unit', 'cost' => 7500, 'sale' => 11000, 'stock' => 90.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Pilsen Latita 354ml', 'sku' => '7840008001028', 'unit' => 'unit', 'cost' => 3200, 'sale' => 4800, 'stock' => 150.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Pilsen Extra Latón 473ml', 'sku' => '7840008001035', 'unit' => 'unit', 'cost' => 4900, 'sale' => 7200, 'stock' => 80.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Brahma Chopp 940ml', 'sku' => '7840009001010', 'unit' => 'unit', 'cost' => 7800, 'sale' => 11500, 'stock' => 80.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Brahma Chopp Latón 473ml', 'sku' => '7840009001027', 'unit' => 'unit', 'cost' => 4800, 'sale' => 7000, 'stock' => 120.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Heineken Long Neck 330ml', 'sku' => '7840010001016', 'unit' => 'unit', 'cost' => 5800, 'sale' => 8500, 'stock' => 60.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Heineken Lata 350ml', 'sku' => '7840010001061', 'unit' => 'unit', 'cost' => 5200, 'sale' => 7800, 'stock' => 80.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Corona Extra 330ml', 'sku' => '7840010001023', 'unit' => 'unit', 'cost' => 6500, 'sale' => 9500, 'stock' => 50.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Budweiser Lata 354ml', 'sku' => '7840010001030', 'unit' => 'unit', 'cost' => 3800, 'sale' => 5500, 'stock' => 90.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Munich Lata 354ml', 'sku' => '7840010001047', 'unit' => 'unit', 'cost' => 2800, 'sale' => 4200, 'stock' => 100.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Stella Artois 330ml', 'sku' => '7840010001054', 'unit' => 'unit', 'cost' => 6200, 'sale' => 9000, 'stock' => 45.0, 'zone' => 'bar'],
                ['name' => 'Cerveza Skol Lata 350ml', 'sku' => '7891149101014', 'unit' => 'unit', 'cost' => 3100, 'sale' => 4600, 'stock' => 70.0, 'zone' => 'bar'],

                // Vinos y Destilados
                ['name' => 'Vino Santa Helena Cabernet 750ml', 'sku' => '7804300101015', 'unit' => 'unit', 'cost' => 21000, 'sale' => 29500, 'stock' => 30.0, 'zone' => 'bar'],
                ['name' => 'Vino Trapiche Malbec 750ml', 'sku' => '7790240101012', 'unit' => 'unit', 'cost' => 28000, 'sale' => 39000, 'stock' => 25.0, 'zone' => 'bar'],
                ['name' => 'Vino Concha y Toro Reservado 750ml', 'sku' => '7804320101014', 'unit' => 'unit', 'cost' => 23000, 'sale' => 32500, 'stock' => 25.0, 'zone' => 'bar'],
                ['name' => 'Vino Tinto Uvita Tetrabrick 1L', 'sku' => '7790120101016', 'unit' => 'unit', 'cost' => 9800, 'sale' => 14000, 'stock' => 40.0, 'zone' => 'bar'],
                ['name' => 'Vino Termidor Tinto 1L', 'sku' => '7790120101023', 'unit' => 'unit', 'cost' => 10500, 'sale' => 15000, 'stock' => 35.0, 'zone' => 'bar'],
                ['name' => 'Caña Tres Leones Etiqueta Azul 1L', 'sku' => '7840014001012', 'unit' => 'unit', 'cost' => 16000, 'sale' => 23000, 'stock' => 30.0, 'zone' => 'bar'],
                ['name' => 'Caña Aristócrata 1L', 'sku' => '7840014002019', 'unit' => 'unit', 'cost' => 18000, 'sale' => 25500, 'stock' => 25.0, 'zone' => 'bar'],
                ['name' => 'Whisky Johnnie Walker Red Label 750ml', 'sku' => '5000267014008', 'unit' => 'unit', 'cost' => 68000, 'sale' => 95000, 'stock' => 15.0, 'zone' => 'bar'],
                ['name' => 'Whisky Johnnie Walker Black Label 750ml', 'sku' => '5000267014015', 'unit' => 'unit', 'cost' => 135000, 'sale' => 189000, 'stock' => 10.0, 'zone' => 'bar'],
                ['name' => 'Whisky White Horse 1L', 'sku' => '5000267015005', 'unit' => 'unit', 'cost' => 48000, 'sale' => 69000, 'stock' => 18.0, 'zone' => 'bar'],
                ['name' => 'Vodka Smirnoff Red 700ml', 'sku' => '5000267016002', 'unit' => 'unit', 'cost' => 32000, 'sale' => 46000, 'stock' => 20.0, 'zone' => 'bar'],
                ['name' => 'Fernet Branca 750ml', 'sku' => '7790410101018', 'unit' => 'unit', 'cost' => 45000, 'sale' => 63000, 'stock' => 25.0, 'zone' => 'bar'],
                ['name' => 'Gin Gordon\'s London Dry 750ml', 'sku' => '5000267017009', 'unit' => 'unit', 'cost' => 39000, 'sale' => 56000, 'stock' => 15.0, 'zone' => 'bar'],

                // Aguas y Jugos
                ['name' => 'Agua Mineral La Fuente sin gas 2L', 'sku' => '7840015001011', 'unit' => 'unit', 'cost' => 3100, 'sale' => 4800, 'stock' => 90.0, 'zone' => 'bar'],
                ['name' => 'Agua Mineral Dasani 500ml', 'sku' => '7840001004019', 'unit' => 'unit', 'cost' => 2200, 'sale' => 3500, 'stock' => 100.0, 'zone' => 'bar'],
                ['name' => 'Agua con Gas Seltz 2L', 'sku' => '7840015001028', 'unit' => 'unit', 'cost' => 3400, 'sale' => 5200, 'stock' => 70.0, 'zone' => 'bar'],
                ['name' => 'Jugo Frutika Naranja 100% 1L', 'sku' => '7840016001010', 'unit' => 'unit', 'cost' => 6800, 'sale' => 9800, 'stock' => 50.0, 'zone' => 'bar'],
                ['name' => 'Jugo Frugos Durazno 1L', 'sku' => '7840001005016', 'unit' => 'unit', 'cost' => 5500, 'sale' => 7900, 'stock' => 40.0, 'zone' => 'bar'],
                ['name' => 'Jugo Ades Manzana 1L', 'sku' => '7840001005023', 'unit' => 'unit', 'cost' => 6200, 'sale' => 8900, 'stock' => 35.0, 'zone' => 'bar'],
                ['name' => 'Bebida Isotónica Gatorade Blue 500ml', 'sku' => '7840007002019', 'unit' => 'unit', 'cost' => 4500, 'sale' => 6500, 'stock' => 45.0, 'zone' => 'bar'],
                ['name' => 'Energizante Monster Energy 473ml', 'sku' => '70847811169', 'unit' => 'unit', 'cost' => 8500, 'sale' => 12500, 'stock' => 60.0, 'zone' => 'bar'],
                ['name' => 'Energizante Red Bull 250ml', 'sku' => '90162909', 'unit' => 'unit', 'cost' => 9200, 'sale' => 13500, 'stock' => 50.0, 'zone' => 'bar'],
                ['name' => 'Bolsa de Hielo en Rolito 5kg', 'sku' => 'HIE-ROL-01', 'unit' => 'unit', 'cost' => 4000, 'sale' => 7000, 'stock' => 40.0, 'zone' => 'bar'],
            ],

            // =========================================================================
            // 4. ALMACÉN Y COMESTIBLES (55 items)
            // =========================================================================
            'Almacén y Comestibles' => [
                // Arroz, Harinas y Granos
                ['name' => 'Arroz Tío Nico Tipo 1 00000 1kg', 'sku' => '7840017001019', 'unit' => 'unit', 'cost' => 5200, 'sale' => 7200, 'stock' => 100.0],
                ['name' => 'Arroz Primicia 00000 1kg', 'sku' => '7840018001018', 'unit' => 'unit', 'cost' => 5400, 'sale' => 7500, 'stock' => 90.0],
                ['name' => 'Arroz Parboilizado Tío Nico 1kg', 'sku' => '7840017001026', 'unit' => 'unit', 'cost' => 6000, 'sale' => 8400, 'stock' => 50.0],
                ['name' => 'Harina de Trigo Hildebrand 000 1kg', 'sku' => '7840019001017', 'unit' => 'unit', 'cost' => 4600, 'sale' => 6400, 'stock' => 100.0],
                ['name' => 'Harina de Trigo Hildebrand 0000 1kg', 'sku' => '7840019001024', 'unit' => 'unit', 'cost' => 5200, 'sale' => 7200, 'stock' => 80.0],
                ['name' => 'Harina Leudante Blancaflor 1kg', 'sku' => '7790070101018', 'unit' => 'unit', 'cost' => 6800, 'sale' => 9500, 'stock' => 50.0],
                ['name' => 'Harina de Maíz Koch Extra Fina 1kg', 'sku' => '7840020001013', 'unit' => 'unit', 'cost' => 5800, 'sale' => 8200, 'stock' => 60.0],
                ['name' => 'Harina de Maíz Avatí Guaraní 1kg', 'sku' => '7840020001020', 'unit' => 'unit', 'cost' => 5500, 'sale' => 7900, 'stock' => 40.0],
                ['name' => 'Almidón de Mandioca Primicia 1kg', 'sku' => '7840018002015', 'unit' => 'unit', 'cost' => 7200, 'sale' => 10500, 'stock' => 55.0],
                ['name' => 'Poroto Rojo Seco Primicia 500g', 'sku' => '7840018003012', 'unit' => 'unit', 'cost' => 4500, 'sale' => 6500, 'stock' => 40.0],
                ['name' => 'Poroto Negro Seco Primicia 500g', 'sku' => '7840018003036', 'unit' => 'unit', 'cost' => 4800, 'sale' => 6900, 'stock' => 35.0],
                ['name' => 'Lentejas Selección Primicia 500g', 'sku' => '7840018003029', 'unit' => 'unit', 'cost' => 5200, 'sale' => 7500, 'stock' => 35.0],
                ['name' => 'Sal Fina de Mesa Primicia 500g', 'sku' => '7840018004019', 'unit' => 'unit', 'cost' => 1800, 'sale' => 2800, 'stock' => 120.0],
                ['name' => 'Sal Gruesa Parrillera Dos Anclas 1kg', 'sku' => '7790150101017', 'unit' => 'unit', 'cost' => 3200, 'sale' => 4800, 'stock' => 80.0],
                ['name' => 'Azúcar Blanco Refinado Azpa 1kg', 'sku' => '7840021001012', 'unit' => 'unit', 'cost' => 4800, 'sale' => 6600, 'stock' => 100.0],
                ['name' => 'Azúcar Orgánico Iturbe 1kg', 'sku' => '7840021001029', 'unit' => 'unit', 'cost' => 5500, 'sale' => 7800, 'stock' => 40.0],

                // Aceites y Condimentos
                ['name' => 'Aceite de Girasol Primicia 900ml', 'sku' => '7840018005016', 'unit' => 'unit', 'cost' => 8200, 'sale' => 11500, 'stock' => 70.0],
                ['name' => 'Aceite de Girasol Primicia 1.5L', 'sku' => '7840018005023', 'unit' => 'unit', 'cost' => 13500, 'sale' => 18900, 'stock' => 40.0],
                ['name' => 'Aceite de Soja Bella Esperanza 900ml', 'sku' => '7840022005012', 'unit' => 'unit', 'cost' => 6500, 'sale' => 9200, 'stock' => 80.0],
                ['name' => 'Aceite de Oliva Extra Virgen Cocinero 500ml', 'sku' => '7790060101011', 'unit' => 'unit', 'cost' => 24000, 'sale' => 34000, 'stock' => 25.0],
                ['name' => 'Vinagre de Alcohol Primicia 500ml', 'sku' => '7840018006013', 'unit' => 'unit', 'cost' => 2400, 'sale' => 3600, 'stock' => 45.0],
                ['name' => 'Vinagre de Manzana Menoyo 500ml', 'sku' => '7790200101014', 'unit' => 'unit', 'cost' => 4800, 'sale' => 7000, 'stock' => 30.0],
                ['name' => 'Orégano Seco Primicia Sobre 25g', 'sku' => '7840018009014', 'unit' => 'unit', 'cost' => 1500, 'sale' => 2500, 'stock' => 80.0],
                ['name' => 'Pimienta Negra Molida Primicia 25g', 'sku' => '7840018009021', 'unit' => 'unit', 'cost' => 2000, 'sale' => 3200, 'stock' => 70.0],
                ['name' => 'Comino Molido Primicia 25g', 'sku' => '7840018009038', 'unit' => 'unit', 'cost' => 1800, 'sale' => 2900, 'stock' => 60.0],
                ['name' => 'Laurel en Hojas Primicia 10g', 'sku' => '7840018009045', 'unit' => 'unit', 'cost' => 1600, 'sale' => 2600, 'stock' => 50.0],

                // Fideos y Pastas
                ['name' => 'Fideos Spaghetti Anita 500g', 'sku' => '7840023001013', 'unit' => 'unit', 'cost' => 3600, 'sale' => 5200, 'stock' => 80.0],
                ['name' => 'Fideos Tallarín Hildebrand 500g', 'sku' => '7840019002014', 'unit' => 'unit', 'cost' => 3800, 'sale' => 5500, 'stock' => 70.0],
                ['name' => 'Fideos Tirabuzón Anita 500g', 'sku' => '7840023001020', 'unit' => 'unit', 'cost' => 3600, 'sale' => 5200, 'stock' => 60.0],
                ['name' => 'Fideos Nido Anita 500g', 'sku' => '7840023001037', 'unit' => 'unit', 'cost' => 4200, 'sale' => 6100, 'stock' => 50.0],
                ['name' => 'Fideos Codito Anita 500g', 'sku' => '7840023001044', 'unit' => 'unit', 'cost' => 3600, 'sale' => 5200, 'stock' => 55.0],
                ['name' => 'Fideos Caracol Anita 500g', 'sku' => '7840023001051', 'unit' => 'unit', 'cost' => 3600, 'sale' => 5200, 'stock' => 45.0],
                ['name' => 'Fideos de Arroz Lucchetti 500g', 'sku' => '7790070202012', 'unit' => 'unit', 'cost' => 5800, 'sale' => 8400, 'stock' => 30.0],

                // Yerbas, Café y Té
                ['name' => 'Yerba Mate Kurupí Menta y Boldo 500g', 'sku' => '7840024001012', 'unit' => 'unit', 'cost' => 8500, 'sale' => 12000, 'stock' => 90.0],
                ['name' => 'Yerba Mate Kurupí Menta y Limón 500g', 'sku' => '7840024001036', 'unit' => 'unit', 'cost' => 8500, 'sale' => 12000, 'stock' => 70.0],
                ['name' => 'Yerba Mate Kurupí Clásica 500g', 'sku' => '7840024001029', 'unit' => 'unit', 'cost' => 7800, 'sale' => 11000, 'stock' => 60.0],
                ['name' => 'Yerba Mate Pajarito Especial 500g', 'sku' => '7840025001011', 'unit' => 'unit', 'cost' => 8200, 'sale' => 11500, 'stock' => 70.0],
                ['name' => 'Yerba Mate Campesino Menta y Limón 500g', 'sku' => '7840026001010', 'unit' => 'unit', 'cost' => 8000, 'sale' => 11400, 'stock' => 65.0],
                ['name' => 'Yerba Mate Campesino Anís 500g', 'sku' => '7840026001027', 'unit' => 'unit', 'cost' => 8000, 'sale' => 11400, 'stock' => 50.0],
                ['name' => 'Yerba Mate Selecta Tradicional 500g', 'sku' => '7840027001019', 'unit' => 'unit', 'cost' => 7500, 'sale' => 10800, 'stock' => 50.0],
                ['name' => 'Yerba Mate Colón Especial 500g', 'sku' => '7840027002016', 'unit' => 'unit', 'cost' => 7900, 'sale' => 11200, 'stock' => 40.0],
                ['name' => 'Café Soluble Nescafé Clásico 100g', 'sku' => '7613035101015', 'unit' => 'unit', 'cost' => 16000, 'sale' => 22900, 'stock' => 45.0, 'zone' => 'bar'],
                ['name' => 'Café Molido Mayo Suave 250g', 'sku' => '7840028001018', 'unit' => 'unit', 'cost' => 11500, 'sale' => 16500, 'stock' => 35.0, 'zone' => 'bar'],
                ['name' => 'Café Molido Cabrales 250g', 'sku' => '7790180101018', 'unit' => 'unit', 'cost' => 19000, 'sale' => 27500, 'stock' => 25.0, 'zone' => 'bar'],
                ['name' => 'Té Guaraní Manzanilla 25 Saquitos', 'sku' => '7840029001017', 'unit' => 'unit', 'cost' => 3800, 'sale' => 5600, 'stock' => 40.0, 'zone' => 'bar'],
                ['name' => 'Té Guaraní Boldo Digestivo 25 Saquitos', 'sku' => '7840029001024', 'unit' => 'unit', 'cost' => 3800, 'sale' => 5600, 'stock' => 40.0, 'zone' => 'bar'],
                ['name' => 'Té Negro Taragüí 25 Saquitos', 'sku' => '7790380101017', 'unit' => 'unit', 'cost' => 4200, 'sale' => 6200, 'stock' => 35.0, 'zone' => 'bar'],
                ['name' => 'Cocido Quemado Abuelita Tradicional 200g', 'sku' => '7840030001013', 'unit' => 'unit', 'cost' => 6500, 'sale' => 9500, 'stock' => 50.0, 'zone' => 'bar'],
                ['name' => 'Edulcorante Líquido Chuker 250ml', 'sku' => '7790310101011', 'unit' => 'unit', 'cost' => 5200, 'sale' => 7800, 'stock' => 40.0],

                // Salsas y Enlatados
                ['name' => 'Extracto de Tomate Primicia Lata 70g', 'sku' => '7840018007010', 'unit' => 'unit', 'cost' => 1600, 'sale' => 2500, 'stock' => 120.0],
                ['name' => 'Salsa de Tomate Pomarola Knorr 340g', 'sku' => '7840031001012', 'unit' => 'unit', 'cost' => 3400, 'sale' => 5000, 'stock' => 80.0],
                ['name' => 'Mayonesa Hellmann\'s Doypack 250g', 'sku' => '7790040101015', 'unit' => 'unit', 'cost' => 5600, 'sale' => 8200, 'stock' => 70.0],
                ['name' => 'Mostaza Savora Clásica Doypack 200g', 'sku' => '7790040102012', 'unit' => 'unit', 'cost' => 4200, 'sale' => 6200, 'stock' => 50.0],
                ['name' => 'Ketchup Primicia Doypack 250g', 'sku' => '7840018008017', 'unit' => 'unit', 'cost' => 4800, 'sale' => 7000, 'stock' => 60.0],
                ['name' => 'Atún en Trozos en Aceite Campagnola 170g', 'sku' => '7790070301012', 'unit' => 'unit', 'cost' => 8200, 'sale' => 11900, 'stock' => 60.0],
                ['name' => 'Atún al Natural Gomes da Costa 170g', 'sku' => '7891000101016', 'unit' => 'unit', 'cost' => 8500, 'sale' => 12500, 'stock' => 50.0],
                ['name' => 'Sardinas en Salsa de Tomate La Góndola 125g', 'sku' => '7840032001011', 'unit' => 'unit', 'cost' => 4500, 'sale' => 6800, 'stock' => 50.0],
                ['name' => 'Arvejas en Lata Bonduelle 300g', 'sku' => '7840033001013', 'unit' => 'unit', 'cost' => 3200, 'sale' => 4900, 'stock' => 70.0],
                ['name' => 'Choclo Amarillo en Granos Bonduelle 300g', 'sku' => '7840033001020', 'unit' => 'unit', 'cost' => 4100, 'sale' => 6200, 'stock' => 65.0],
                ['name' => 'Picadillo de Carne Norteño 90g', 'sku' => '7840034001012', 'unit' => 'unit', 'cost' => 2400, 'sale' => 3700, 'stock' => 100.0],
                ['name' => 'Paté de Hígado Norteño 90g', 'sku' => '7840034001029', 'unit' => 'unit', 'cost' => 2600, 'sale' => 3900, 'stock' => 90.0],
            ],

            // =========================================================================
            // 5. PANADERÍA, CONFITERÍA Y ROTISERÍA (25 items)
            // =========================================================================
            'Panadería y Confitería' => [
                ['name' => 'Pan Francés / Felipe Fresco', 'sku' => 'PAN-FRA-01', 'unit' => 'kg', 'cost' => 6500, 'sale' => 9500, 'stock' => 60.0],
                ['name' => 'Pan Galleta Cuartel Criolla', 'sku' => 'PAN-GAL-01', 'unit' => 'kg', 'cost' => 7000, 'sale' => 10500, 'stock' => 50.0],
                ['name' => 'Pan Trinchera Rústico', 'sku' => 'PAN-TRI-01', 'unit' => 'kg', 'cost' => 6500, 'sale' => 9500, 'stock' => 40.0],
                ['name' => 'Pan Porteño Suave', 'sku' => 'PAN-POR-01', 'unit' => 'kg', 'cost' => 7500, 'sale' => 11000, 'stock' => 35.0],
                ['name' => 'Chipa Tradicional Barrero unidad', 'sku' => 'CHI-BAR-01', 'unit' => 'unit', 'cost' => 3000, 'sale' => 5000, 'stock' => 50.0, 'zone' => 'kitchen'],
                ['name' => 'Chipa So\'o Rellena con Carne', 'sku' => 'CHI-SOO-01', 'unit' => 'unit', 'cost' => 4500, 'sale' => 7000, 'stock' => 35.0, 'zone' => 'kitchen'],
                ['name' => 'Chipa Pirí Crocante Bolsa 200g', 'sku' => 'CHI-PIR-01', 'unit' => 'unit', 'cost' => 6000, 'sale' => 9500, 'stock' => 30.0],
                ['name' => 'Chipa Guasú Porción 250g', 'sku' => 'CHI-GUA-01', 'unit' => 'unit', 'cost' => 5500, 'sale' => 9000, 'stock' => 25.0, 'zone' => 'kitchen'],
                ['name' => 'Sopa Paraguaya Tradicional Porción 250g', 'sku' => 'SOP-PAR-01', 'unit' => 'unit', 'cost' => 5500, 'sale' => 9000, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Pan de Miga Blanco Bimbo 500g', 'sku' => '7840035001011', 'unit' => 'unit', 'cost' => 8500, 'sale' => 12000, 'stock' => 40.0],
                ['name' => 'Pan de Salvado Bimbo 500g', 'sku' => '7840035001028', 'unit' => 'unit', 'cost' => 9200, 'sale' => 13200, 'stock' => 30.0],
                ['name' => 'Pan de Hamburguesa Bimbo 4u', 'sku' => '7840035001035', 'unit' => 'unit', 'cost' => 6200, 'sale' => 8900, 'stock' => 45.0],
                ['name' => 'Pan de Panchos Bimbo 6u', 'sku' => '7840035001042', 'unit' => 'unit', 'cost' => 5800, 'sale' => 8400, 'stock' => 50.0],
                ['name' => 'Tostadas Riera Clásicas 200g', 'sku' => '7790080101014', 'unit' => 'unit', 'cost' => 5200, 'sale' => 7600, 'stock' => 35.0],
                ['name' => 'Medialunas de Manteca Docena', 'sku' => 'PAN-MED-01', 'unit' => 'unit', 'cost' => 14000, 'sale' => 22000, 'stock' => 20.0, 'zone' => 'kitchen'],
                ['name' => 'Medialunas Rellenas de Dulce de Leche 6u', 'sku' => 'PAN-MED-02', 'unit' => 'unit', 'cost' => 9500, 'sale' => 15000, 'stock' => 20.0, 'zone' => 'kitchen'],
                ['name' => 'Pastafrola de Guayaba Porción', 'sku' => 'PAS-GUA-01', 'unit' => 'unit', 'cost' => 4000, 'sale' => 6500, 'stock' => 25.0, 'zone' => 'kitchen'],
                ['name' => 'Empanada de Carne Frita', 'sku' => 'EMP-CAR-01', 'unit' => 'unit', 'cost' => 3000, 'sale' => 5000, 'stock' => 40.0, 'zone' => 'kitchen'],
                ['name' => 'Empanada de Jamón y Queso Frita', 'sku' => 'EMP-JYQ-01', 'unit' => 'unit', 'cost' => 3000, 'sale' => 5000, 'stock' => 40.0, 'zone' => 'kitchen'],
                ['name' => 'Empanada de Pollo al Horno', 'sku' => 'EMP-POL-01', 'unit' => 'unit', 'cost' => 3000, 'sale' => 5000, 'stock' => 35.0, 'zone' => 'kitchen'],
                ['name' => 'Sándwich de Miga Jamón y Queso triple', 'sku' => 'SAN-JYQ-01', 'unit' => 'unit', 'cost' => 4500, 'sale' => 7500, 'stock' => 30.0, 'zone' => 'kitchen'],
                ['name' => 'Milanesa de Carne al Plato', 'sku' => 'MIL-PLA-01', 'unit' => 'unit', 'cost' => 9000, 'sale' => 16000, 'stock' => 20.0, 'zone' => 'kitchen'],
                ['name' => 'Marinera de Carne', 'sku' => 'MAR-CAR-01', 'unit' => 'unit', 'cost' => 6000, 'sale' => 10000, 'stock' => 25.0, 'zone' => 'kitchen'],
                ['name' => 'Mbeyú Tradicional unidad', 'sku' => 'MBE-TRA-01', 'unit' => 'unit', 'cost' => 3500, 'sale' => 6000, 'stock' => 20.0, 'zone' => 'kitchen'],
                ['name' => 'Mbeyú con 4 Quesos', 'sku' => 'MBE-4QU-01', 'unit' => 'unit', 'cost' => 5500, 'sale' => 9500, 'stock' => 15.0, 'zone' => 'kitchen'],
            ],

            // =========================================================================
            // 6. FRUTERÍA Y VERDULERÍA (30 items)
            // =========================================================================
            'Frutería y Verdulería' => [
                ['name' => 'Tomate Santa Cruz Seleccionado', 'sku' => 'VER-TOM-01', 'unit' => 'kg', 'cost' => 6000, 'sale' => 9500, 'stock' => 80.0],
                ['name' => 'Tomate Lisa para Ensalada', 'sku' => 'VER-TOM-02', 'unit' => 'kg', 'cost' => 7000, 'sale' => 11000, 'stock' => 50.0],
                ['name' => 'Cebolla Blanca Lavada', 'sku' => 'VER-CEB-01', 'unit' => 'kg', 'cost' => 4200, 'sale' => 6800, 'stock' => 100.0],
                ['name' => 'Cebolla Morada', 'sku' => 'VER-CEB-02', 'unit' => 'kg', 'cost' => 5500, 'sale' => 8500, 'stock' => 40.0],
                ['name' => 'Papa Blanca Lavada Especial', 'sku' => 'VER-PAP-01', 'unit' => 'kg', 'cost' => 4500, 'sale' => 7200, 'stock' => 120.0],
                ['name' => 'Papa Negra', 'sku' => 'VER-PAP-02', 'unit' => 'kg', 'cost' => 3800, 'sale' => 6000, 'stock' => 60.0],
                ['name' => 'Zanahoria Selección', 'sku' => 'VER-ZAN-01', 'unit' => 'kg', 'cost' => 3800, 'sale' => 5900, 'stock' => 60.0],
                ['name' => 'Locote Verde Nacional', 'sku' => 'VER-LOC-01', 'unit' => 'kg', 'cost' => 6500, 'sale' => 10500, 'stock' => 45.0],
                ['name' => 'Locote Rojo Importado', 'sku' => 'VER-LOC-02', 'unit' => 'kg', 'cost' => 11000, 'sale' => 16800, 'stock' => 30.0],
                ['name' => 'Mandioca Fresca Pelada y Lavada', 'sku' => 'VER-MAN-01', 'unit' => 'kg', 'cost' => 2000, 'sale' => 3800, 'stock' => 150.0],
                ['name' => 'Zapallo Criollo / Calabaza', 'sku' => 'VER-ZAP-01', 'unit' => 'kg', 'cost' => 2800, 'sale' => 4600, 'stock' => 50.0],
                ['name' => 'Calabacita Italiana / Zucchini', 'sku' => 'VER-CAL-01', 'unit' => 'kg', 'cost' => 4500, 'sale' => 7000, 'stock' => 30.0],
                ['name' => 'Repollo Blanco', 'sku' => 'VER-REP-01', 'unit' => 'kg', 'cost' => 3200, 'sale' => 5200, 'stock' => 40.0],
                ['name' => 'Repollo Morado', 'sku' => 'VER-REP-02', 'unit' => 'kg', 'cost' => 4000, 'sale' => 6500, 'stock' => 25.0],
                ['name' => 'Lechuga Hidropónica Mazo', 'sku' => 'VER-LEC-01', 'unit' => 'unit', 'cost' => 2000, 'sale' => 3500, 'stock' => 30.0],
                ['name' => 'Acelga Fresca Mazo', 'sku' => 'VER-ACE-01', 'unit' => 'unit', 'cost' => 2200, 'sale' => 3800, 'stock' => 25.0],
                ['name' => 'Ajo en Cabeza Importado', 'sku' => 'VER-AJO-01', 'unit' => 'kg', 'cost' => 18000, 'sale' => 26000, 'stock' => 20.0],
                ['name' => 'Pepino Fresco', 'sku' => 'VER-PEP-01', 'unit' => 'kg', 'cost' => 3500, 'sale' => 5500, 'stock' => 35.0],
                ['name' => 'Remolacha Seleccionada', 'sku' => 'VER-REM-01', 'unit' => 'kg', 'cost' => 4000, 'sale' => 6200, 'stock' => 40.0],
                ['name' => 'Banana Karape Dulce', 'sku' => 'FRU-BAN-01', 'unit' => 'kg', 'cost' => 3800, 'sale' => 6000, 'stock' => 90.0],
                ['name' => 'Banana Oro Pequeña', 'sku' => 'FRU-BAN-02', 'unit' => 'kg', 'cost' => 4500, 'sale' => 7000, 'stock' => 40.0],
                ['name' => 'Manzana Roja Gala Importada', 'sku' => 'FRU-MAN-01', 'unit' => 'kg', 'cost' => 9500, 'sale' => 14500, 'stock' => 60.0],
                ['name' => 'Manzana Verde Granny Smith', 'sku' => 'FRU-MAN-03', 'unit' => 'kg', 'cost' => 10500, 'sale' => 15500, 'stock' => 40.0],
                ['name' => 'Naranja Dulce Nacional Docena', 'sku' => 'FRU-NAR-01', 'unit' => 'unit', 'cost' => 6000, 'sale' => 9500, 'stock' => 40.0],
                ['name' => 'Limón Sutil Verde', 'sku' => 'FRU-LIM-01', 'unit' => 'kg', 'cost' => 4500, 'sale' => 7500, 'stock' => 50.0],
                ['name' => 'Mandarina Nacional Docena', 'sku' => 'FRU-MAN-02', 'unit' => 'unit', 'cost' => 5500, 'sale' => 8800, 'stock' => 35.0],
                ['name' => 'Pera Williams', 'sku' => 'FRU-PER-01', 'unit' => 'kg', 'cost' => 10500, 'sale' => 15800, 'stock' => 30.0],
                ['name' => 'Aguacate / Palta Criolla', 'sku' => 'FRU-AGU-01', 'unit' => 'kg', 'cost' => 7000, 'sale' => 11500, 'stock' => 30.0],
                ['name' => 'Sandía Roja Entera Grande', 'sku' => 'FRU-SAN-01', 'unit' => 'unit', 'cost' => 12000, 'sale' => 20000, 'stock' => 25.0],
                ['name' => 'Melón Amarillo Dulce unidad', 'sku' => 'FRU-MEL-01', 'unit' => 'unit', 'cost' => 8000, 'sale' => 13500, 'stock' => 20.0],
                ['name' => 'Piña / Ananá Nacional unidad', 'sku' => 'FRU-PIN-01', 'unit' => 'unit', 'cost' => 5000, 'sale' => 8500, 'stock' => 25.0],
            ],

            // =========================================================================
            // 7. SNACKS, GOLOSINAS Y GALLETITAS (35 items)
            // =========================================================================
            'Snacks, Golosinas y Galletitas' => [
                ['name' => 'Papas Fritas Lay\'s Clásicas 85g', 'sku' => '7840036001010', 'unit' => 'unit', 'cost' => 5800, 'sale' => 8500, 'stock' => 60.0],
                ['name' => 'Papas Fritas Lay\'s Jamón Serrano 85g', 'sku' => '7840036001041', 'unit' => 'unit', 'cost' => 5800, 'sale' => 8500, 'stock' => 45.0],
                ['name' => 'Doritos Mega Queso Nacho 90g', 'sku' => '7840036001027', 'unit' => 'unit', 'cost' => 6200, 'sale' => 9200, 'stock' => 50.0],
                ['name' => 'Cheetos Horneados Queso 80g', 'sku' => '7840036001034', 'unit' => 'unit', 'cost' => 4800, 'sale' => 7200, 'stock' => 55.0],
                ['name' => 'Papas Pringles Original Tubo 137g', 'sku' => '38000138410', 'unit' => 'unit', 'cost' => 14000, 'sale' => 19900, 'stock' => 35.0],
                ['name' => 'Papas Pringles Cebolla y Crema 137g', 'sku' => '38000138427', 'unit' => 'unit', 'cost' => 14000, 'sale' => 19900, 'stock' => 35.0],
                ['name' => 'Maní Tostado Salado Crok 100g', 'sku' => '7840037001019', 'unit' => 'unit', 'cost' => 2500, 'sale' => 3900, 'stock' => 80.0],
                ['name' => 'Maní Japonés Crok 100g', 'sku' => '7840037001026', 'unit' => 'unit', 'cost' => 2800, 'sale' => 4200, 'stock' => 60.0],
                ['name' => 'Galletitas Oreo Original 117g', 'sku' => '7622300101015', 'unit' => 'unit', 'cost' => 3800, 'sale' => 5500, 'stock' => 70.0],
                ['name' => 'Galletitas Oreo Chocolate 117g', 'sku' => '7622300101022', 'unit' => 'unit', 'cost' => 3800, 'sale' => 5500, 'stock' => 50.0],
                ['name' => 'Galletitas Chocolinas Bagley 170g', 'sku' => '7790040301012', 'unit' => 'unit', 'cost' => 4600, 'sale' => 6800, 'stock' => 65.0],
                ['name' => 'Galletitas Criollitas Bagley 100g', 'sku' => '7790040302019', 'unit' => 'unit', 'cost' => 2600, 'sale' => 3900, 'stock' => 80.0],
                ['name' => 'Galletitas Club Social Original Pack 6u', 'sku' => '7622300201012', 'unit' => 'unit', 'cost' => 5800, 'sale' => 8500, 'stock' => 50.0],
                ['name' => 'Galletitas Nikolo Rellenas Frutilla 120g', 'sku' => '7840038001018', 'unit' => 'unit', 'cost' => 2800, 'sale' => 4200, 'stock' => 60.0],
                ['name' => 'Galletitas Nikolo Rellenas Chocolate 120g', 'sku' => '7840038001025', 'unit' => 'unit', 'cost' => 2800, 'sale' => 4200, 'stock' => 60.0],
                ['name' => 'Galletitas Wafer Bauducco Chocolate 140g', 'sku' => '7891962010108', 'unit' => 'unit', 'cost' => 4200, 'sale' => 6300, 'stock' => 50.0],
                ['name' => 'Alfajor Tatakua Chocolate Negro', 'sku' => '7840039001017', 'unit' => 'unit', 'cost' => 4500, 'sale' => 6900, 'stock' => 50.0],
                ['name' => 'Alfajor Tatakua Chocolate Blanco', 'sku' => '7840039001024', 'unit' => 'unit', 'cost' => 4500, 'sale' => 6900, 'stock' => 40.0],
                ['name' => 'Alfajor Guaymallén Triple Chocolate', 'sku' => '7790090101013', 'unit' => 'unit', 'cost' => 2200, 'sale' => 3500, 'stock' => 80.0],
                ['name' => 'Alfajor Jorgito Chocolate', 'sku' => '7790090201010', 'unit' => 'unit', 'cost' => 2800, 'sale' => 4200, 'stock' => 60.0],
                ['name' => 'Chocolate Kit Kat Nestlé 41.5g', 'sku' => '7613035201012', 'unit' => 'unit', 'cost' => 4200, 'sale' => 6500, 'stock' => 60.0],
                ['name' => 'Chocolate Nugatón Bonafide 27g', 'sku' => '7790100101019', 'unit' => 'unit', 'cost' => 2000, 'sale' => 3200, 'stock' => 90.0],
                ['name' => 'Chocolate Garoto Serenata de Amor', 'sku' => '7891008010108', 'unit' => 'unit', 'cost' => 1500, 'sale' => 2500, 'stock' => 120.0],
                ['name' => 'Caja de Bombones Garoto 250g', 'sku' => '7891008020107', 'unit' => 'unit', 'cost' => 14500, 'sale' => 21000, 'stock' => 30.0],
                ['name' => 'Barra de Cereal Arcor Frutilla 23g', 'sku' => '7790040401019', 'unit' => 'unit', 'cost' => 1800, 'sale' => 2900, 'stock' => 70.0],
                ['name' => 'Caramelos Halls Menta Fuerte Blister', 'sku' => '7622300301019', 'unit' => 'unit', 'cost' => 2200, 'sale' => 3500, 'stock' => 100.0],
                ['name' => 'Caramelos Halls Cereza Blister', 'sku' => '7622300301026', 'unit' => 'unit', 'cost' => 2200, 'sale' => 3500, 'stock' => 90.0],
                ['name' => 'Chicle Trident Menta sin Azúcar 14u', 'sku' => '7622300401016', 'unit' => 'unit', 'cost' => 3800, 'sale' => 5800, 'stock' => 85.0],
                ['name' => 'Chicle Topline Menta 7u', 'sku' => '7790040402016', 'unit' => 'unit', 'cost' => 2200, 'sale' => 3500, 'stock' => 80.0],
                ['name' => 'Turrón de Maní Arcor 25g', 'sku' => '7790040403013', 'unit' => 'unit', 'cost' => 1200, 'sale' => 2000, 'stock' => 100.0],
                ['name' => 'Chupetín Pico Dulce Arcor', 'sku' => '7790040404010', 'unit' => 'unit', 'cost' => 800, 'sale' => 1500, 'stock' => 150.0],
            ],

            // =========================================================================
            // 8. LIMPIEZA DEL HOGAR (35 items)
            // =========================================================================
            'Limpieza del Hogar' => [
                ['name' => 'Jabón en Polvo OMO Multiacción 800g', 'sku' => '7840040001013', 'unit' => 'unit', 'cost' => 11000, 'sale' => 15900, 'stock' => 60.0],
                ['name' => 'Jabón en Polvo OMO Multiacción 3kg', 'sku' => '7840040001020', 'unit' => 'unit', 'cost' => 38000, 'sale' => 53000, 'stock' => 25.0],
                ['name' => 'Jabón Líquido Skip Concentrado 1L', 'sku' => '7790040501016', 'unit' => 'unit', 'cost' => 18000, 'sale' => 25900, 'stock' => 40.0],
                ['name' => 'Jabón Líquido Ala Camellito 1L', 'sku' => '7790040502013', 'unit' => 'unit', 'cost' => 12500, 'sale' => 17900, 'stock' => 45.0],
                ['name' => 'Jabón en Barra Cavallaro Coco 200g', 'sku' => '7840042002018', 'unit' => 'unit', 'cost' => 2800, 'sale' => 4200, 'stock' => 100.0],
                ['name' => 'Detergente Vajilla Magistral Limón 300ml', 'sku' => '7790040601013', 'unit' => 'unit', 'cost' => 5200, 'sale' => 7800, 'stock' => 70.0],
                ['name' => 'Detergente Vajilla Magistral Marino 500ml', 'sku' => '7790040601020', 'unit' => 'unit', 'cost' => 7500, 'sale' => 10900, 'stock' => 50.0],
                ['name' => 'Detergente Zorro Manzana 500ml', 'sku' => '7840041001012', 'unit' => 'unit', 'cost' => 4200, 'sale' => 6300, 'stock' => 80.0],
                ['name' => 'Lavandina Concentrada Ayudín 1L', 'sku' => '7790110101018', 'unit' => 'unit', 'cost' => 4500, 'sale' => 6700, 'stock' => 90.0],
                ['name' => 'Lavandina Cavallaro Clásica 1L', 'sku' => '7840042001011', 'unit' => 'unit', 'cost' => 3800, 'sale' => 5800, 'stock' => 100.0],
                ['name' => 'Lavandina Cavallaro Clásica 2L', 'sku' => '7840042001028', 'unit' => 'unit', 'cost' => 6800, 'sale' => 9900, 'stock' => 50.0],
                ['name' => 'Limpiador de Pisos Poett Primavera 900ml', 'sku' => '7790110201015', 'unit' => 'unit', 'cost' => 6200, 'sale' => 9100, 'stock' => 50.0],
                ['name' => 'Limpiador de Pisos Poett Lavanda 900ml', 'sku' => '7790110201022', 'unit' => 'unit', 'cost' => 6200, 'sale' => 9100, 'stock' => 50.0],
                ['name' => 'Desinfectante en Aerosol Lysoform 360ml', 'sku' => '7790120201013', 'unit' => 'unit', 'cost' => 12500, 'sale' => 18000, 'stock' => 40.0],
                ['name' => 'Esponja de Cocina Scotch Brite 3M', 'sku' => '7840043001010', 'unit' => 'unit', 'cost' => 2200, 'sale' => 3500, 'stock' => 120.0],
                ['name' => 'Lana de Acero Virulana Pack 10u', 'sku' => '7790190101013', 'unit' => 'unit', 'cost' => 3400, 'sale' => 5200, 'stock' => 80.0],
                ['name' => 'Papel Higiénico Campanita Doble Hoja 4u', 'sku' => '7840044001019', 'unit' => 'unit', 'cost' => 6800, 'sale' => 9900, 'stock' => 80.0],
                ['name' => 'Papel Higiénico Suave Premium 12u', 'sku' => '7840044001026', 'unit' => 'unit', 'cost' => 18000, 'sale' => 25500, 'stock' => 40.0],
                ['name' => 'Servilletas de Papel Campanita 100u', 'sku' => '7840044001033', 'unit' => 'unit', 'cost' => 3400, 'sale' => 5200, 'stock' => 70.0],
                ['name' => 'Toallas de Papel de Cocina Sussex 2u', 'sku' => '7790130101014', 'unit' => 'unit', 'cost' => 5500, 'sale' => 8200, 'stock' => 60.0],
                ['name' => 'Bolsas para Basura 50L Reforzadas Pack 10u', 'sku' => '7840045001018', 'unit' => 'unit', 'cost' => 4800, 'sale' => 7200, 'stock' => 50.0],
                ['name' => 'Bolsas para Basura 100L Negras Pack 10u', 'sku' => '7840045001025', 'unit' => 'unit', 'cost' => 7500, 'sale' => 11000, 'stock' => 40.0],
                ['name' => 'Suavizante para Ropa Vivere 900ml', 'sku' => '7790040701010', 'unit' => 'unit', 'cost' => 8900, 'sale' => 12900, 'stock' => 45.0],
                ['name' => 'Lustramuebles Blem Lavanda Aerosol 360ml', 'sku' => '7790120301010', 'unit' => 'unit', 'cost' => 11000, 'sale' => 16500, 'stock' => 30.0],
                ['name' => 'Insecticida Raid Mata Moscas y Mosquitos 360ml', 'sku' => '7790120401017', 'unit' => 'unit', 'cost' => 12500, 'sale' => 18500, 'stock' => 40.0],
                ['name' => 'Espirales Raid contra Mosquitos Caja 10u', 'sku' => '7790120402014', 'unit' => 'unit', 'cost' => 3200, 'sale' => 5000, 'stock' => 80.0],
                ['name' => 'Fósforos Fragata Tres Estrellas Pack 10u', 'sku' => '7790350101016', 'unit' => 'unit', 'cost' => 3800, 'sale' => 5800, 'stock' => 60.0],
                ['name' => 'Carbón Vegetal Seleccionado Bolsa 3kg', 'sku' => 'CAR-VEG-01', 'unit' => 'unit', 'cost' => 9000, 'sale' => 14500, 'stock' => 40.0],
            ],

            // =========================================================================
            // 9. CUIDADO PERSONAL Y FARMACIA BÁSICA (35 items)
            // =========================================================================
            'Cuidado Personal y Farmacia' => [
                ['name' => 'Jabón de Tocador Dove Original 90g', 'sku' => '7790040801017', 'unit' => 'unit', 'cost' => 4500, 'sale' => 6800, 'stock' => 80.0],
                ['name' => 'Jabón de Tocador Lux Rosas 125g', 'sku' => '7790040901014', 'unit' => 'unit', 'cost' => 3200, 'sale' => 4900, 'stock' => 90.0],
                ['name' => 'Jabón de Tocador Rexona Antibacterial 125g', 'sku' => '7790040902011', 'unit' => 'unit', 'cost' => 3500, 'sale' => 5200, 'stock' => 70.0],
                ['name' => 'Shampoo Sedal Ceramidas 340ml', 'sku' => '7790041001010', 'unit' => 'unit', 'cost' => 12000, 'sale' => 17500, 'stock' => 45.0],
                ['name' => 'Acondicionador Sedal Ceramidas 340ml', 'sku' => '7790041002017', 'unit' => 'unit', 'cost' => 12000, 'sale' => 17500, 'stock' => 40.0],
                ['name' => 'Shampoo Head & Shoulders Limpieza 375ml', 'sku' => '7790050101012', 'unit' => 'unit', 'cost' => 21000, 'sale' => 29900, 'stock' => 35.0],
                ['name' => 'Shampoo Pantene Restauración 400ml', 'sku' => '7790050102019', 'unit' => 'unit', 'cost' => 19500, 'sale' => 27900, 'stock' => 30.0],
                ['name' => 'Desodorante Rexona Men Aerosol 150ml', 'sku' => '7790041101017', 'unit' => 'unit', 'cost' => 12500, 'sale' => 18000, 'stock' => 50.0],
                ['name' => 'Desodorante Dove Original Mujer Aerosol 150ml', 'sku' => '7790041102014', 'unit' => 'unit', 'cost' => 13500, 'sale' => 19500, 'stock' => 45.0],
                ['name' => 'Desodorante Axe Black Aerosol 150ml', 'sku' => '7790041103011', 'unit' => 'unit', 'cost' => 12500, 'sale' => 18000, 'stock' => 40.0],
                ['name' => 'Crema Dental Colgate Triple Acción 90g', 'sku' => '7891030101018', 'unit' => 'unit', 'cost' => 5800, 'sale' => 8500, 'stock' => 80.0],
                ['name' => 'Crema Dental Colgate Total 12 90g', 'sku' => '7891030102015', 'unit' => 'unit', 'cost' => 9500, 'sale' => 13900, 'stock' => 50.0],
                ['name' => 'Cepillo Dental Colgate Extra Clean 1u', 'sku' => '7891030201015', 'unit' => 'unit', 'cost' => 4200, 'sale' => 6400, 'stock' => 60.0],
                ['name' => 'Enjuague Bucal Colgate Plax Menta 250ml', 'sku' => '7891030301012', 'unit' => 'unit', 'cost' => 13500, 'sale' => 19500, 'stock' => 30.0],
                ['name' => 'Toallitas Femeninas Always Suave Noche 8u', 'sku' => '7790050201019', 'unit' => 'unit', 'cost' => 6500, 'sale' => 9800, 'stock' => 50.0],
                ['name' => 'Protectores Diarios Kotex 20u', 'sku' => '7790140301015', 'unit' => 'unit', 'cost' => 4800, 'sale' => 7200, 'stock' => 45.0],
                ['name' => 'Máquina de Afeitar Gillette Prestobarba 3 2u', 'sku' => '7790050401013', 'unit' => 'unit', 'cost' => 11000, 'sale' => 16500, 'stock' => 40.0],
                ['name' => 'Espuma de Afeitar Gillette Clásica 200ml', 'sku' => '7790050402010', 'unit' => 'unit', 'cost' => 14000, 'sale' => 20900, 'stock' => 25.0],
                ['name' => 'Protector Solar Nivea Sun FPS 50 200ml', 'sku' => '4005808101012', 'unit' => 'unit', 'cost' => 42000, 'sale' => 59900, 'stock' => 20.0],
                ['name' => 'Curitas Adhesivas Hansaplast Pack 10u', 'sku' => '4005808201019', 'unit' => 'unit', 'cost' => 3800, 'sale' => 5800, 'stock' => 70.0],
                ['name' => 'Alcohol Etílico 70% Spray 250ml', 'sku' => '7840046001017', 'unit' => 'unit', 'cost' => 4500, 'sale' => 6900, 'stock' => 60.0],
                ['name' => 'Alcohol en Gel 70% 250ml con Dosificador', 'sku' => '7840046001024', 'unit' => 'unit', 'cost' => 5500, 'sale' => 8500, 'stock' => 50.0],
                ['name' => 'Algodón Hidrófilo Fármaco 50g', 'sku' => '7840046002014', 'unit' => 'unit', 'cost' => 2800, 'sale' => 4300, 'stock' => 50.0],
                ['name' => 'Agua Oxigenada 10 Volúmenes 100ml', 'sku' => '7840046003011', 'unit' => 'unit', 'cost' => 2500, 'sale' => 4000, 'stock' => 40.0],
                ['name' => 'Preservativos Prime Clásico Pack 3u', 'sku' => '7790220101018', 'unit' => 'unit', 'cost' => 12000, 'sale' => 18000, 'stock' => 40.0],
            ],

            // =========================================================================
            // 10. BEBÉ Y MASCOTAS (20 items)
            // =========================================================================
            'Bebé y Mascotas' => [
                ['name' => 'Pañales Huggies Natural Care Talla M 48u', 'sku' => '7790140101011', 'unit' => 'unit', 'cost' => 48000, 'sale' => 68000, 'stock' => 30.0],
                ['name' => 'Pañales Huggies Natural Care Talla G 40u', 'sku' => '7790140101028', 'unit' => 'unit', 'cost' => 48000, 'sale' => 68000, 'stock' => 30.0],
                ['name' => 'Pañales Pampers Premium Care G 36u', 'sku' => '7790050301016', 'unit' => 'unit', 'cost' => 52000, 'sale' => 74000, 'stock' => 25.0],
                ['name' => 'Toallitas Húmedas Huggies Puro 48u', 'sku' => '7790140201018', 'unit' => 'unit', 'cost' => 8500, 'sale' => 12500, 'stock' => 40.0],
                ['name' => 'Toallitas Húmedas Pampers Sensitive 56u', 'sku' => '7790050302013', 'unit' => 'unit', 'cost' => 9500, 'sale' => 13900, 'stock' => 35.0],
                ['name' => 'Shampoo para Bebé Johnson\'s Baby 200ml', 'sku' => '7891010101012', 'unit' => 'unit', 'cost' => 14000, 'sale' => 20500, 'stock' => 30.0],
                ['name' => 'Jabón Líquido de Glicerina Johnson\'s Baby 200ml', 'sku' => '7891010102019', 'unit' => 'unit', 'cost' => 13500, 'sale' => 19900, 'stock' => 25.0],
                ['name' => 'Talco para Bebé Johnson\'s 200g', 'sku' => '7891010103016', 'unit' => 'unit', 'cost' => 11000, 'sale' => 16500, 'stock' => 30.0],
                ['name' => 'Mamón / Biberón Avent Classic 260ml', 'sku' => '8710103850102', 'unit' => 'unit', 'cost' => 28000, 'sale' => 42000, 'stock' => 15.0],
                ['name' => 'Alimento para Perros Adultos Pedigree 1kg', 'sku' => '7790160101014', 'unit' => 'unit', 'cost' => 11500, 'sale' => 16900, 'stock' => 45.0],
                ['name' => 'Alimento para Perros Adultos Pedigree 3kg', 'sku' => '7790160101021', 'unit' => 'unit', 'cost' => 32000, 'sale' => 46000, 'stock' => 25.0],
                ['name' => 'Alimento para Perros Cachorros Dog Chow 1.5kg', 'sku' => '7613035302016', 'unit' => 'unit', 'cost' => 19500, 'sale' => 28000, 'stock' => 30.0],
                ['name' => 'Alimento para Perros Dog Chow Carne 1.5kg', 'sku' => '7613035301019', 'unit' => 'unit', 'cost' => 18000, 'sale' => 26000, 'stock' => 35.0],
                ['name' => 'Alimento para Gatos Whiskas Pescado 1kg', 'sku' => '7790160201011', 'unit' => 'unit', 'cost' => 14000, 'sale' => 20900, 'stock' => 40.0],
                ['name' => 'Alimento para Gatos Whiskas Carne 1kg', 'sku' => '7790160201028', 'unit' => 'unit', 'cost' => 14000, 'sale' => 20900, 'stock' => 35.0],
                ['name' => 'Pouch Whiskas Salsa Salmón 85g', 'sku' => '7790160203015', 'unit' => 'unit', 'cost' => 3200, 'sale' => 4800, 'stock' => 60.0],
                ['name' => 'Pouch Pedigree Trozos de Carne 100g', 'sku' => '7790160103018', 'unit' => 'unit', 'cost' => 3200, 'sale' => 4800, 'stock' => 60.0],
                ['name' => 'Piedras Sanitarias para Gatos 2kg', 'sku' => '7840048001016', 'unit' => 'unit', 'cost' => 7500, 'sale' => 11200, 'stock' => 40.0],
            ],
        ];

        $totalInserted = 0;

        foreach ($catalog as $categoryName => $products) {
            // Find or create Category
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                [
                    'id' => (string) Str::uuid(),
                    'slug' => Str::slug($categoryName),
                    'is_active' => true,
                ]
            );

            foreach ($products as $p) {
                // Ensure unique SKU
                $sku = $p['sku'];
                $product = Product::updateOrCreate(
                    ['sku' => $sku],
                    [
                        'id' => (string) Str::uuid(),
                        'name' => $p['name'],
                        'slug' => Str::slug($p['name'] . '-' . Str::random(4)),
                        'description' => $p['name'] . ' - Producto Minimercado',
                        'price_cost' => (int) $p['cost'],
                        'price_sale' => (int) $p['sale'],
                        'discount_percentage' => 0,
                        'stock' => (float) $p['stock'],
                        'min_stock' => $p['unit'] === 'kg' ? 5.0 : 3.0,
                        'category_id' => $category->id,
                        'is_active' => true,
                        'unit_type' => $p['unit'] ?? 'unit',
                        'manage_stock' => true,
                        'has_variations' => false,
                        'is_raw_material' => $p['raw'] ?? false,
                        'product_type' => ($p['raw'] ?? false) ? 'raw_material' : 'standard',
                        'production_zone' => $p['zone'] ?? 'none',
                    ]
                );

                // Set BranchStock for this product in branch
                BranchStock::updateOrCreate(
                    [
                        'branch_id' => $branch->id,
                        'stockable_id' => $product->id,
                        'stockable_type' => Product::class,
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'stock' => (float) $p['stock'],
                    ]
                );

                $totalInserted++;
            }
        }

        $this->command->info("Seeder completado con éxito. Total productos procesados: {$totalInserted} en " . count($catalog) . " categorías.");
    }
}
