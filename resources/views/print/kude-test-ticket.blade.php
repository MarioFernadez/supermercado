<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KuDE Cinta Papel - Test #{{ $testDoc['numero_factura'] }}</title>
    <style>
        @page {
            margin: 0;
            size: 80mm auto;
        }
        body {
            font-family: 'Courier New', Courier, monospace, sans-serif;
            font-size: 11px;
            line-height: 1.25;
            margin: 0;
            padding: 8px 6px;
            width: 78mm;
            background: #fff;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .dashed-line {
            border-bottom: 1px dashed #000;
            margin: 6px 0;
        }
        .banner-test {
            border: 2px dashed #000;
            padding: 4px;
            font-weight: bold;
            font-size: 9.5px;
            text-align: center;
            margin-bottom: 6px;
            line-height: 1.15;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }
        .items-table th {
            border-bottom: 1px dashed #000;
            padding: 2px 0;
        }
        .items-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .row-between {
            display: flex;
            justify-content: space-between;
        }
        .qr-container {
            display: flex;
            justify-content: center;
            margin: 8px 0;
        }
        .qr-container svg {
            width: 125px;
            height: 125px;
        }
        .cdc-box {
            font-size: 8.5px;
            font-weight: bold;
            word-break: break-all;
            text-align: center;
            letter-spacing: 0.5px;
            background: #f0f0f0;
            padding: 4px;
            border: 1px solid #000;
            margin: 4px 0;
        }
        .legal-notice {
            font-size: 8px;
            text-align: center;
            margin-top: 5px;
            line-height: 1.2;
        }
        @media print {
            .no-print { display: none !important; }
            body { padding: 4px; width: 78mm; }
        }
    </style>
</head>
<body>

    <!-- Botón de prueba para pantalla -->
    <div class="no-print" style="margin-bottom: 10px; text-align: center;">
        <button onclick="window.print()" style="padding: 6px 14px; font-weight: bold; background: #4f46e5; color: #fff; border: none; border-radius: 6px; cursor: pointer;">
            🖨️ Imprimir Ticket de Prueba
        </button>
    </div>

    <!-- Banner obligatorio de ambiente de prueba -->
    <div class="banner-test">
        *** AMBIENTE DE PRUEBA ***<br>
        DOCUMENTO ELECTRÓNICO SIN VALOR COMERCIAL NI FISCAL
    </div>

    <!-- Encabezado KuDE -->
    <div class="text-center">
        <div style="font-size: 12px; font-weight: bold;">KuDE DE FACTURA ELECTRÓNICA</div>
        <div style="font-size: 10px; font-weight: bold; margin-top: 2px;">{{ $testDoc['razon_social'] }}</div>
        <div>RUC: {{ $testDoc['emisor_ruc'] }}</div>
        <div>{{ $settings['sifen_emisor_direccion'] ?? 'Avda. Principal 1234' }}</div>
        <div>Tel: {{ $settings['sifen_emisor_telefono'] ?? '021123456' }}</div>
    </div>

    <div class="dashed-line"></div>

    <!-- Timbrado y Factura -->
    <div>
        <div><strong>Timbrado N°:</strong> {{ $testDoc['timbrado'] }}</div>
        <div><strong>Factura N°:</strong> {{ $testDoc['numero_factura'] }}</div>
        <div><strong>Fecha y Hora:</strong> {{ $testDoc['fecha_emision'] }}</div>
        <div><strong>Condición de Venta:</strong> {{ $testDoc['condicion'] }}</div>
        <div class="dashed-line"></div>
        <div><strong>Cliente:</strong> {{ $testDoc['cliente'] }}</div>
        <div><strong>RUC / CI:</strong> {{ $testDoc['cliente_ruc'] }}</div>
    </div>

    <div class="dashed-line"></div>

    <!-- Detalle de Ítems -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 12%; text-align: left;">Cant</th>
                <th style="width: 48%; text-align: left;">Detalle</th>
                <th style="width: 20%; text-align: right;">P.Unit</th>
                <th style="width: 20%; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testDoc['items'] as $item)
            <tr>
                <td>{{ $item['quantity'] }}</td>
                <td style="word-break: break-word;">{{ $item['name'] }}</td>
                <td class="text-right">{{ number_format($item['price'], 0, '', '.') }}</td>
                <td class="text-right">{{ number_format($item['subtotal'], 0, '', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="dashed-line"></div>

    <!-- Totales y Liquidación IVA -->
    <div>
        <div class="row-between bold" style="font-size: 12px;">
            <span>TOTAL A PAGAR:</span>
            <span>Gs. {{ number_format($testDoc['total'], 0, '', '.') }}</span>
        </div>
        <div style="margin-top: 4px; font-size: 10px;">
            <div class="row-between">
                <span>Subtotal Gravadas 10%:</span>
                <span>Gs. {{ number_format($testDoc['total'] - $testDoc['total_iva'], 0, '', '.') }}</span>
            </div>
            <div class="row-between">
                <span>Subtotal Gravadas 5%:</span>
                <span>Gs. 0</span>
            </div>
            <div class="row-between">
                <span>Subtotal Exentas:</span>
                <span>Gs. 0</span>
            </div>
            <div class="row-between bold" style="margin-top: 3px; border-top: 1px dotted #000; padding-top: 2px;">
                <span>LIQUIDACIÓN TOTAL IVA:</span>
                <span>Gs. {{ number_format($testDoc['total_iva'], 0, '', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="dashed-line"></div>

    <!-- QR Code y CDC Oficial -->
    <div class="text-center">
        <div class="qr-container">
            {!! $testDoc['qr_svg'] !!}
        </div>
        <div style="font-size: 8.5px;">
            Consulte la validez en:<br>
            <span class="bold">https://ekuatia.set.gov.py/consultas-test/</span>
        </div>
        <div class="cdc-box">
            CDC: {{ $testDoc['cdc_formatted'] }}
        </div>
        <div class="legal-notice">
            ESTE DOCUMENTO ES UNA REPRESENTACIÓN GRÁFICA DE UN DOCUMENTO ELECTRÓNICO (XML)<br>
            Si su documento electrónico presenta algún error, podrá solicitar la modificación dentro de las 72 horas siguientes a la emisión.
        </div>
    </div>

    <script>
        window.onload = function() {
            // Se puede descomentar para impresión automática
            // window.print();
        }
    </script>
</body>
</html>
