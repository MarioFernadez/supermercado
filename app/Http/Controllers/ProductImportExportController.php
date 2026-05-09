<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ProductImportExportController extends Controller
{
    public function export() 
    {
        return Excel::download(new ProductsExport, 'productos.xlsx');
    }
   
    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);
       
        try {
            Excel::import(new ProductsImport, $request->file('file'));
            return back()->with('message', 'Productos importados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function template()
    {
        // Generate a sample collection with one example row
        $templateData = collect([
            [
                'nombre' => 'Ejemplo Producto',
                'sku' => 'COD123',
                'categoria' => 'Bebidas',
                'proveedor' => 'Proveedor A',
                'precio_costo' => 5000,
                'precio_venta' => 8000,
                'stock' => 10,
                'stock_minimo' => 5,
                'unidad_medida' => 'unit',
                'controlar_stock' => 'Si',
                'activo' => 'Si',
            ]
        ]);

        return Excel::download(new class($templateData) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;
            public function __construct($data) { $this->data = $data; }
            public function collection() { return $this->data; }
            public function headings(): array {
                return [
                    'Nombre', 'SKU', 'Categoría', 'Proveedor', 'Precio Costo', 'Precio Venta', 'Stock', 'Stock Mínimo', 'Unidad Medida', 'Controlar Stock', 'Activo'
                ];
            }
        }, 'plantilla_productos.xlsx');
    }
}
