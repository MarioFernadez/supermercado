<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with(['category', 'supplier'])->get();
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'SKU',
            'Categoría',
            'Proveedor',
            'Precio Costo',
            'Precio Venta',
            'Stock',
            'Stock Mínimo',
            'Unidad Medida',
            'Controlar Stock',
            'Activo',
        ];
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->sku,
            $product->category ? $product->category->name : '',
            $product->supplier ? $product->supplier->name : '',
            $product->price_cost,
            $product->price_sale,
            $product->stock,
            $product->min_stock,
            $product->unit_type,
            $product->manage_stock ? 'Si' : 'No',
            $product->is_active ? 'Si' : 'No',
        ];
    }
}
