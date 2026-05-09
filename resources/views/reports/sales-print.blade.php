<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
        }
    </style>
</head>
<body class="bg-white p-8">
    
    <script>
        window.onload = function() {
            window.print();
        }
        window.onafterprint = function() {
            window.close();
        }
    </script>
    
    <!-- Header -->
    <div class="mb-8 border-b pb-4">
        <h1 class="text-2xl font-bold text-gray-800">ZonaPOS - Reporte de Ventas</h1>
        <p class="text-gray-600">Periodo: <span class="font-bold">{{ \Carbon\Carbon::parse($from)->format('d/m/Y') }}</span> al <span class="font-bold">{{ \Carbon\Carbon::parse($to)->format('d/m/Y') }}</span></p>
        <p class="text-sm text-gray-500 mt-1">Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Financial Summary -->
    <div class="mb-8 grid grid-cols-2 gap-8">
        <div>
            <h3 class="font-bold text-gray-800 mb-2 border-b">Resumen Financiero</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-gray-500">Ventas Totales:</span>
                    <span class="block font-bold text-lg">₲ {{ format_pyg($profitStats['sales']) }}</span>
                </div>
                <div>
                    <span class="block text-gray-500">Costo Estimado:</span>
                    <span class="block font-bold text-lg text-red-600">₲ {{ format_pyg($profitStats['cost']) }}</span>
                </div>
                <div>
                    <span class="block text-gray-500">Ganancia:</span>
                    <span class="block font-bold text-lg text-green-600">₲ {{ format_pyg($profitStats['profit']) }}</span>
                </div>
                <div>
                    <span class="block text-gray-500">Margen:</span>
                    <span class="block font-bold text-lg">{{ number_format($profitStats['margin'], 1) }}%</span>
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-gray-800 mb-2 border-b">Desglose Medios de Pago</h3>
            <table class="w-full text-sm">
                @foreach($paymentMethods as $payment)
                <tr>
                    <td class="py-1 text-gray-600">{{ ucfirst($payment->method) }}</td>
                    <td class="py-1 text-right font-bold">₲ {{ format_pyg($payment->total) }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-gray-800 pl-2">Detalle de Ventas ({{ $sales->count() }})</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-gray-300">
                    <th class="py-2 text-sm">Fecha</th>
                    <th class="py-2 text-sm">Ticket</th>
                    <th class="py-2 text-sm">Cliente</th>
                    <th class="py-2 text-sm">Cajero</th>
                    <th class="py-2 text-sm">Vendedor</th>
                    <th class="py-2 text-sm text-right">Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-sm">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-2 text-sm font-mono">{{ $sale->invoice_number }}</td>
                        <td class="py-2 text-sm">{{ $sale->customer ? $sale->customer->name : 'Consumidor Final' }}</td>
                        <td class="py-2 text-sm">{{ $sale->user?->name ?? '—' }}</td>
                        <td class="py-2 text-sm">{{ $sale->seller?->name ?? '—' }}</td>
                        <td class="py-2 text-sm font-bold text-right">₲ {{ format_pyg($sale->total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Sold Products Table -->
    <div class="mb-8 break-inside-avoid">
        <h2 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-gray-800 pl-2">Resumen de Productos Vendidos</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-gray-300">
                    <th class="py-2 text-sm">Producto</th>
                    <th class="py-2 text-sm text-center">Cantidad</th>
                    <th class="py-2 text-sm text-right">Total Generado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($soldProducts as $item)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-sm">{{ $item->product_name }}</td>
                        <td class="py-2 text-sm text-center">{{ $item->total_qty }}</td>
                        <td class="py-2 text-sm font-bold text-right">₲ {{ format_pyg($item->total_amount) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Suppliers Table -->
    <div class="mb-8 break-inside-avoid">
        <h2 class="text-lg font-bold text-gray-800 mb-2 border-l-4 border-gray-800 pl-2">Ventas por Proveedor</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-gray-300">
                    <th class="py-2 text-sm">Proveedor</th>
                    <th class="py-2 text-sm text-center">Items Vendidos</th>
                    <th class="py-2 text-sm text-right">Total Generado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salesBySupplier as $supplier)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-sm font-bold">{{ $supplier->supplier_name }}</td>
                        <td class="py-2 text-sm text-center">{{ $supplier->items_count }}</td>
                        <td class="py-2 text-sm font-bold text-right">₲ {{ format_pyg($supplier->total_sales) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-center mt-12 text-xs text-gray-400 no-print">
        <button onclick="window.close()" class="underline hover:text-gray-600">Cerrar Ventana</button>
    </div>

</body>
</html>
