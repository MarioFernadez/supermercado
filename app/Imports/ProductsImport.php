<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Find or Create Category
        $categoryId = null;
        if (!empty($row['categoria'])) {
            $category = Category::firstOrCreate(
                ['name' => $row['categoria']],
                [
                    'slug' => \Illuminate\Support\Str::slug($row['categoria']),
                    'is_active' => true
                ]
            );
            $categoryId = $category->id;
        }

        // Find or Create Supplier
        $supplierId = null;
        if (!empty($row['proveedor'])) {
            $supplier = Supplier::firstOrCreate(
                ['name' => $row['proveedor']],
                ['active' => true]
            );
            $supplierId = $supplier->id;
        }

        // Try to find existing product
        $product = null;
        
        // 1. Match by SKU if provided
        if (!empty($row['sku'])) {
            $product = Product::where('sku', $row['sku'])->first();
        }
        
        // 2. Match by Name if no SKU or not found by SKU
        if (!$product && !empty($row['nombre'])) {
            $product = Product::where('name', $row['nombre'])->first();
        }

        // 3. Prepare SKU (Keep existing if found, or use provided, or generate new)
        if ($product) {
            $sku = $product->sku;
        } else {
            $sku = $row['sku'];
            if (empty($sku)) {
                 do {
                    $sku = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
                } while (Product::where('sku', $sku)->exists());
            }
        }

        // 4. Update or Create
        return Product::updateOrCreate(
            ['id' => $product ? $product->id : null], // Use ID to force update if found
            [
                'name' => $row['nombre'],
                'sku' => $sku,
                'price_cost' => $row['precio_costo'],
                'price_sale' => $row['precio_venta'],
                'stock' => isset($row['stock']) ? ($product ? $product->stock + $row['stock'] : $row['stock']) : ($product ? $product->stock : 0), // Optional: decide if stock replaces or adds. Usually imports replace. Let's assume replace for consistency, or maybe the user wants to add? Standard is replace or sync. Let's stick to REPLACING data to fix the bad supplier issue, but keep stock is risky if they use it for inventory. 
                // WAIT. If they re-import to fix Supplier, they might overwrite stock?
                // User asked: "Si importo el mismo archivo...". Usually this implies resetting to file state.
                // Let's stick to the values in the row.
                'stock' => $row['stock'] ?? ($product ? $product->stock : 0),
                'min_stock' => $row['stock_minimo'] ?? 5,
                'category_id' => $categoryId,
                'supplier_id' => $supplierId,
                'unit_type' => $row['unidad_medida'] ?? 'unit',
                'manage_stock' => strtolower($row['controlar_stock'] ?? 'si') === 'si' || $row['controlar_stock'] === 1,
                'is_active' => strtolower($row['activo'] ?? 'si') === 'si' || $row['activo'] === 1,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required',
            'precio_costo' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            // 'sku' => 'unique:products,sku', // We handle SKU generation/checking manually or let DB throw error? logic above handles generation.
        ];
    }
}
