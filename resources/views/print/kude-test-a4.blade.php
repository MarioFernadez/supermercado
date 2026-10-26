<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KuDE Factura Electrónica A4 - Test #{{ $testDoc['numero_factura'] }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #111;
            margin: 0;
            padding: 15px;
            background: #fff;
        }
        .border-box {
            border: 1px solid #333;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 8px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
        }
        .title-doc {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
            margin-top: 6px;
        }
        .table-data th {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 5px;
            font-weight: bold;
        }
        .table-data td {
            border: 1px solid #cbd5e1;
            padding: 5px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .banner-test {
            background-color: #fef3c7;
            border: 2px dashed #d97706;
            color: #92400e;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 10px;
        }
        .cdc-display {
            font-family: monospace;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            background: #f8fafc;
            border: 1px solid #94a3b8;
            padding: 6px;
            text-align: center;
            margin: 6px 0;
        }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 18px; font-weight: bold; background: #4f46e5; color: #fff; border: none; border-radius: 8px; cursor: pointer;">
            🖨️ Imprimir Factura A4
        </button>
    </div>

    <div class="banner-test">
        *** DOCUMENTO ELECTRÓNICO SIN VALOR COMERCIAL NI FISCAL - GENERADO EN AMBIENTE DE PRUEBA ***
    </div>

    <!-- Encabezado Principal Cuadrante Oficial MT v150 -->
    <div class="border-box">
        <table class="header-table">
            <tr>
                <td style="width: 55%;">
                    <div class="title-doc">KuDE DE FACTURA ELECTRÓNICA</div>
                    <div style="font-size: 12px; font-weight: bold; margin-top: 4px;">{{ $testDoc['razon_social'] }}</div>
                    <div><strong>Nombre de Fantasía:</strong> {{ $settings['sifen_emisor_nombre_fantasia'] ?? 'ZonaShop' }}</div>
                    <div><strong>Dirección:</strong> {{ $settings['sifen_emisor_direccion'] ?? 'Avda. Principal 1234' }}</div>
                    <div><strong>Teléfono:</strong> {{ $settings['sifen_emisor_telefono'] ?? '021123456' }} | <strong>Email:</strong> {{ $settings['sifen_emisor_email'] ?? 'facturacion@zonapos.com' }}</div>
                    <div><strong>Ciudad:</strong> {{ $settings['sifen_emisor_ciudad_desc'] ?? 'Asunción' }} - Paraguay</div>
                </td>
                <td style="width: 45%; text-align: right; border-left: 1px solid #e2e8f0; padding-left: 10px;">
                    <div style="font-size: 13px; font-weight: bold;">RUC: {{ $testDoc['emisor_ruc'] }}</div>
                    <div style="margin-top: 3px;"><strong>Timbrado N°:</strong> {{ $testDoc['timbrado'] }}</div>
                    <div><strong>Inicio Vigencia:</strong> {{ $settings['sifen_timbrado_fecha_inicio'] ?? '2024-01-01' }}</div>
                    <div style="font-size: 14px; font-weight: bold; color: #1e293b; margin-top: 6px;">
                        FACTURA ELECTRÓNICA<br>
                        N° {{ $testDoc['numero_factura'] }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Datos de la Operación y Receptor -->
    <div class="border-box">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%;"><strong>Fecha y Hora de Emisión:</strong> {{ $testDoc['fecha_emision'] }}</td>
                <td style="width: 50%;"><strong>Condición de Venta:</strong> {{ $testDoc['condicion'] }}</td>
            </tr>
            <tr>
                <td><strong>Moneda:</strong> PYG (Guaraníes)</td>
                <td><strong>Tipo de Operación:</strong> Venta de Mercadería (B2C)</td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: 1px dashed #cbd5e1; padding-top: 4px; margin-top: 4px;">
                    <strong>RUC / Documento de Identidad:</strong> {{ $testDoc['cliente_ruc'] }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Nombre o Razón Social:</strong> {{ $testDoc['cliente'] }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Tabla de Ítems -->
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 8%;">Código</th>
                <th style="width: 46%;">Descripción del Producto o Servicio</th>
                <th style="width: 8%;">Unidad</th>
                <th style="width: 8%;">Cant</th>
                <th style="width: 15%;" class="text-right">Precio Unitario</th>
                <th style="width: 15%;" class="text-right">Valor Venta (10%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testDoc['items'] as $item)
            <tr>
                <td class="text-center">{{ $item['id'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td class="text-center">UNI</td>
                <td class="text-center">{{ $item['quantity'] }}</td>
                <td class="text-right">{{ number_format($item['price'], 0, '', '.') }}</td>
                <td class="text-right">{{ number_format($item['subtotal'], 0, '', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales y Liquidación IVA -->
    <div class="border-box" style="margin-top: 8px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 65%;">
                    <div style="font-size: 11px;">
                        <strong>SUBTOTAL GRAVADAS 10%:</strong> Gs. {{ number_format($testDoc['total'] - $testDoc['total_iva'], 0, '', '.') }}<br>
                        <strong>SUBTOTAL GRAVADAS 5%:</strong> Gs. 0<br>
                        <strong>SUBTOTAL EXENTAS:</strong> Gs. 0<br>
                        <strong>LIQUIDACIÓN IVA 10%:</strong> Gs. {{ number_format($testDoc['total_iva'], 0, '', '.') }}<br>
                        <strong>TOTAL LIQUIDACIÓN IVA:</strong> Gs. {{ number_format($testDoc['total_iva'], 0, '', '.') }}
                    </div>
                </td>
                <td style="width: 35%; text-align: right; vertical-align: bottom;">
                    <div style="font-size: 11px; text-transform: uppercase; color: #64748b;">Total de la Operación</div>
                    <div style="font-size: 18px; font-weight: black; color: #0f172a;">
                        Gs. {{ number_format($testDoc['total'], 0, '', '.') }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Código QR y CDC Oficial -->
    <div class="border-box" style="margin-top: 8px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 140px; text-align: center; vertical-align: middle;">
                    <div style="display: inline-block; padding: 4px; border: 1px solid #cbd5e1; border-radius: 4px;">
                        {!! $testDoc['qr_svg'] !!}
                    </div>
                </td>
                <td style="padding-left: 15px; vertical-align: middle;">
                    <div style="font-size: 10px; color: #475569;">
                        Consulte la validez de este Documento Tributario Electrónico con el número de CDC impreso abajo en:<br>
                        <strong class="text-indigo-600">https://ekuatia.set.gov.py/consultas-test/</strong>
                    </div>
                    <div class="cdc-display">
                        CDC: {{ $testDoc['cdc_formatted'] }}
                    </div>
                    <div style="font-size: 9px; color: #64748b; line-height: 1.3;">
                        ESTE DOCUMENTO ES UNA REPRESENTACIÓN GRÁFICA DE UN DOCUMENTO ELECTRÓNICO (XML).<br>
                        Si su documento electrónico presenta algún error, podrá solicitar la modificación dentro de las 72 horas siguientes de la emisión de este comprobante.
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
