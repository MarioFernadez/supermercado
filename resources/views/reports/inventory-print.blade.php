<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #111; margin: 20px; }
        h1 { font-size: 16px; margin-bottom: 4px; }
        .meta { color: #555; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f1f5f9; text-align: left; padding: 6px 8px; font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #d1d5db; }
        td { padding: 5px 8px; border-bottom: 1px solid #e5e7eb; }
        tr.low td { background: #fffbeb; }
        tr.out td { background: #fef2f2; }
        .right { text-align: right; }
        .center { text-align: center; }
        .totals { margin-top: 16px; border-top: 2px solid #111; padding-top: 8px; }
        .totals td { font-weight: bold; font-size: 13px; }
        @media print { @page { margin: 15mm; } }
    </style>
</head>
<body>
    <h1>📦 Inventario de Productos</h1>
    <p class="meta">Generado: {{ now()->format('d/m/Y H:i') }}
        @if($filterCategory) | Categoría: {{ $categories->find($filterCategory)?->name }} @endif
        @if($filterSupplier) | Proveedor: {{ $suppliers->find($filterSupplier)?->name }} @endif
    </p>

    <!-- KPIs -->
    <table style="margin-bottom:16px; width:auto;">
        <tr>
            <td style="padding-right:24px;"><strong>Productos:</strong> {{ $products->count() }}</td>
            <td style="padding-right:24px;"><strong>Total unidades:</strong> {{ number_format($products->sum('stock'), 0) }}</td>
            <td style="padding-right:24px;"><strong>Valor total stock:</strong> ₲ {{ format_pyg($products->sum(fn($p) => $p->stock * $p->price_cost)) }}</td>
            <td style="padding-right:24px;"><strong>Sin stock:</strong> {{ $products->where('manage_stock', true)->where('stock', 0)->count() }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>SKU</th>
                <th>Categoría</th>
                <th>Proveedor</th>
                <th class="right">Stock</th>
                <th class="right">Mínimo</th>
                <th class="right">P. Costo</th>
                <th class="right">Valor Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                @php
                    $stockStatus = !$product->manage_stock ? '' : ($product->stock == 0 ? 'out' : ($product->stock <= $product->min_stock ? 'low' : ''));
                @endphp
                <tr class="{{ $stockStatus }}">
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->category?->name ?? '—' }}</td>
                    <td>{{ $product->supplier?->name ?? '—' }}</td>
                    <td class="right">{{ $product->manage_stock ? number_format($product->stock, 2, ',', '.') : '∞' }}</td>
                    <td class="right">{{ $product->manage_stock ? $product->min_stock : '—' }}</td>
                    <td class="right">₲ {{ format_pyg($product->price_cost) }}</td>
                    <td class="right">{{ $product->manage_stock ? '₲ '.format_pyg($product->stock * $product->price_cost) : '—' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="totals">
            <tr>
                <td colspan="6">TOTAL</td>
                <td></td>
                <td class="right">₲ {{ format_pyg($products->sum(fn($p) => $p->stock * $p->price_cost)) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
