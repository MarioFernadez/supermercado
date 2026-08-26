<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Impresión de Etiquetas</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .no-print {
            padding: 20px;
            text-align: center;
            background: #fff;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .no-print button {
            padding: 10px 20px;
            background-color: #4F46E5;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }

        .no-print button:hover {
            background-color: #4338CA;
        }

        /* Formato A4 (Plantilla 3x7 o similar) */
        @media screen {
            .format-a4 .page {
                width: 210mm;
                min-height: 297mm;
                padding: 10mm;
                margin: 0 auto;
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 5mm;
                align-content: start;
            }
        }

        /* Formato Rollo Térmico (Ej: 50x25mm) */
        @media screen {
            .format-thermal .page {
                width: 50mm;
                background: transparent;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            .format-thermal .label {
                width: 50mm;
                height: 25mm;
                background: white;
                box-shadow: 0 0 5px rgba(0,0,0,0.2);
                margin: 0;
            }
        }

        .label {
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
            background: #fff;
        }

        .format-a4 .label {
            border: 1px dashed #ccc;
            height: 38.1mm; /* Standard height for 65 labels/A4 or similar */
            padding: 2mm;
        }

        .format-thermal .label {
            padding: 1mm;
        }

        .label-name {
            font-size: 10px;
            font-weight: bold;
            line-height: 1.1;
            max-height: 22px;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }

        .format-thermal .label-name {
            font-size: 9px;
            max-height: 10px;
            white-space: nowrap;
        }

        .label-price {
            font-size: 12px;
            font-weight: 900;
            margin-top: 2px;
        }

        .format-thermal .label-price {
            font-size: 10px;
        }

        svg.barcode {
            max-width: 100%;
            height: auto;
            max-height: 22mm;
        }

        .format-thermal svg.barcode {
            max-height: 12mm;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white;
            }

            .format-a4 .label {
                border: none;
            }

            .format-a4 .page {
                box-shadow: none;
                margin: 0;
            }
        }

        /* Print page size overrides */
        @page {
            margin: 0;
        }
    </style>
    
    @if($format === 'thermal')
    <style>
        @media print {
            @page {
                size: 50mm 25mm;
                margin: 0;
            }
            .page {
                width: 100%;
                height: 100%;
                display: block !important;
            }
            .label {
                width: 100%;
                height: 100%;
                page-break-after: always;
                box-shadow: none;
            }
        }
    </style>
    @else
    <style>
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }
            .page {
                page-break-after: always;
            }
        }
    </style>
    @endif

</head>
<body class="format-{{ $format }}">

    <div class="no-print">
        <h2>Vista Previa de Etiquetas ({{ count($labelsToPrint) }} etiquetas)</h2>
        <p>Formato seleccionado: <strong>{{ $format === 'a4' ? 'A4 (Grilla)' : 'Rollo Térmico (50x25mm)' }}</strong></p>
        <button onclick="window.print()">Imprimir Ahora</button>
        <button onclick="window.close()" style="background-color: #6B7280; margin-left: 10px;">Cerrar</button>
    </div>

    <div class="page">
        @foreach($labelsToPrint as $product)
            <div class="label">
                @if($includeName)
                    <div class="label-name">{{ $product->name }}</div>
                @endif
                
                <svg class="barcode" 
                     jsbarcode-format="auto" 
                     jsbarcode-value="{{ $product->sku }}" 
                     jsbarcode-textmargin="0" 
                     jsbarcode-fontoptions="bold"
                     jsbarcode-height="{{ $format === 'thermal' ? '30' : '40' }}"
                     jsbarcode-fontsize="{{ $format === 'thermal' ? '10' : '14' }}"
                     jsbarcode-margin="0">
                </svg>

                @if($includePrice)
                    <div class="label-price">₲ {{ format_pyg($product->price_sale) }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <script>
        // Init JsBarcode on all SVG elements with 'barcode' class
        JsBarcode(".barcode").init();
    </script>
</body>
</html>
