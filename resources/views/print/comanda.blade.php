<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comanda</title>
    <style>
        @media print {
            @page {
                size: 80mm auto;
                margin: 5mm;
            }
            body { margin: 0; }
            .no-print { display: none; }
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            padding: 12px;
            max-width: 80mm;
            margin: 0 auto;
            color: #000;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 22px;
            font-weight: 900;
            text-transform: uppercase;
            margin: 0 0 4px 0;
        }
        .header p { margin: 2px 0; font-size: 13px; }
        .zone-block {
            margin-bottom: 14px;
        }
        .zone-label {
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
            margin-bottom: 8px;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 900;
            margin-bottom: 6px;
        }
        .item-row .qty {
            font-size: 22px;
            font-weight: 900;
            min-width: 30px;
        }
        .item-row .name { flex: 1; padding-left: 8px; }
        .footer {
            border-top: 2px dashed #000;
            padding-top: 8px;
            font-size: 11px;
            text-align: center;
            margin-top: 10px;
        }
        .btn-print {
            display: block;
            margin: 20px auto;
            background: #1e1b4b;
            color: white;
            border: none;
            padding: 12px 32px;
            font-size: 16px;
            font-weight: 900;
            border-radius: 8px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .btn-print:hover { background: #312e81; }
    </style>
</head>
<body>

<button class="btn-print no-print" onclick="window.print()">🖨️ Imprimir Comanda</button>

@php
    $data = json_decode(base64_decode(request('payload')), true);
    $table  = $data['table'] ?? 'Sin Mesa';
    $waiter = $data['waiter'] ?? 'Sin Mozo';
    $items  = $data['items'] ?? [];

    $kitchenItems = collect($items)->filter(fn($i) => $i['zone'] === 'kitchen');
    $barItems     = collect($items)->filter(fn($i) => $i['zone'] === 'bar');
    $directItems  = collect($items)->filter(fn($i) => $i['zone'] === 'none');
@endphp

<div class="header">
    <h1>🍽️ COMANDA</h1>
    <p><strong>{{ $table }}</strong></p>
    <p>Mozo: {{ $waiter }}</p>
    <p>Hora: {{ now()->format('H:i') }}</p>
</div>

@if($kitchenItems->isNotEmpty())
<div class="zone-block">
    <div class="zone-label">🍳 Cocina</div>
    @foreach($kitchenItems as $item)
    <div class="item-row">
        <span class="qty">{{ $item['qty'] }}x</span>
        <span class="name">{{ strtoupper($item['name']) }}</span>
    </div>
    @endforeach
</div>
@endif

@if($barItems->isNotEmpty())
<div class="zone-block">
    <div class="zone-label">🍹 Barra</div>
    @foreach($barItems as $item)
    <div class="item-row">
        <span class="qty">{{ $item['qty'] }}x</span>
        <span class="name">{{ strtoupper($item['name']) }}</span>
    </div>
    @endforeach
</div>
@endif

@if($directItems->isNotEmpty())
<div class="zone-block">
    <div class="zone-label">📋 General</div>
    @foreach($directItems as $item)
    <div class="item-row">
        <span class="qty">{{ $item['qty'] }}x</span>
        <span class="name">{{ strtoupper($item['name']) }}</span>
    </div>
    @endforeach
</div>
@endif

<div class="footer">
    <p>Generado por ZonaShop POS</p>
</div>

<script>
    // Auto-open print dialog
    window.addEventListener('load', function() {
        setTimeout(() => window.print(), 500);
    });
</script>
</body>
</html>
