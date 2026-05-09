<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 5px;
            width: 80mm; /* Standard thermal paper width */
            background-color: #fff;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }
        .store-name {
            font-size: 16px;
            font-weight: bold;
        }
        .info {
            margin-bottom: 10px;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .items th {
            text-align: left;
            border-bottom: 1px dashed black;
        }
        .items td {
            padding: 2px 0;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            margin-top: 10px;
            border-top: 1px dashed black;
            padding-top: 5px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 14px;
        }
        @media print {
            body {
                width: auto;
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="store-name">{{ $settings['store_name'] ?? 'ZonaPOS' }}</div>
        <div>RUC: {{ $settings['store_ruc'] ?? '---' }}</div>
        <div>{{ $settings['store_address'] ?? '' }}</div>
        <div>Tel: {{ $settings['store_phone'] ?? '' }}</div>
    </div>

    <div class="info">
        <div>Ticket #: {{ $sale->invoice_number }}</div>
        <div>Fecha: {{ $sale->created_at->format('d/m/Y H:i') }}</div>
        <div>Cajero: {{ $sale->user->name }}</div>
        @if($sale->seller)
        <div>Vendedor: {{ $sale->seller->name }}</div>
        @endif
        <div>Cliente: {{ $sale->customer ? $sale->customer->name : 'Consumidor Final' }}</div>
        <div>RUC/CI: {{ $sale->customer ? $sale->customer->ruc : '---' }}</div>
        <div>Condición: {{ strtoupper($sale->payment_condition) }}</div>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 10%">Cant</th>
                <th style="width: 50%">Prod</th>
                <th style="width: 20%" class="text-right">Precio</th>
                <th style="width: 20%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->quantity }}</td>
                <td>{{ Str::limit($item->product->name, 20) }}</td>
                <td class="text-right">{{ number_format($item->price_unit, 0, '', '.') }}</td>
                <td class="text-right">{{ number_format($item->subtotal, 0, '', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div style="display: flex; justify-content: space-between;">
            <span>Subtotal:</span>
            <span>{{ format_pyg($sale->total - $sale->tax_amount) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span>IVA:</span>
            <span>{{ format_pyg($sale->tax_amount) }}</span>
        </div>
        <div class="total-row">
            <span>TOTAL:</span>
            <span>Gs. {{ format_pyg($sale->total) }}</span>
        </div>
        
        @if($sale->payments->count() > 0)
        <div style="margin-top: 10px; border-top: 1px dashed black; padding-top: 5px;">
            <div style="font-weight: bold; margin-bottom: 3px;">Pagos:</div>
            @foreach($sale->payments as $payment)
            <div style="display: flex; justify-content: space-between;">
                <span>{{ ucfirst($payment->method) }}:</span>
                <span>Gs. {{ number_format($payment->amount, 0, '', '.') }}</span>
            </div>
            @if($payment->method === 'cheque')
                <div style="font-size: 10px; margin-left: 10px; margin-bottom: 2px;">
                    <div>Banco: {{ $payment->bank_name }}</div>
                    <div>Nro: {{ $payment->cheque_number }}</div>
                    <div>Fecha: {{ \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') }}</div>
                </div>
            @endif
            @endforeach
        </div>
        @endif
    </div>

    <div class="footer">
        <div>{{ $settings['ticket_footer'] ?? 'Gracias por su compra' }}</div>
        <br>
        <button onclick="window.print()" class="no-print" style="padding: 10px; cursor: pointer;">Imprimir</button>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
        window.onafterprint = function() {
            window.close();
        }
    </script>
</body>
</html>
