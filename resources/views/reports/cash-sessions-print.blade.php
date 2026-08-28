<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Cierres de Caja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
            .avoid-break { break-inside: avoid; }
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
        <h1 class="text-2xl font-bold text-gray-800">ZonaPOS - Historial de Cierres de Caja</h1>
        <p class="text-gray-600">Periodo: <span class="font-bold">{{ \Carbon\Carbon::parse($from)->format('d/m/Y') }}</span> al <span class="font-bold">{{ \Carbon\Carbon::parse($to)->format('d/m/Y') }}</span></p>
        <p class="text-sm text-gray-500 mt-1">Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Sessions Table -->
    <div class="mb-12">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b-2 border-gray-300">
                    <th class="py-2">Cajero/a</th>
                    <th class="py-2 text-center">Apertura</th>
                    <th class="py-2 text-center">Cierre</th>
                    <th class="py-2 text-right">Inicial</th>
                    <th class="py-2 text-right">Calculado</th>
                    <th class="py-2 text-right">Real</th>
                    <th class="py-2 text-right">Diferencia</th>
                    <th class="py-2 pl-2">Notas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 font-medium">{{ $session->user->name }}</td>
                        <td class="py-2 text-center">{{ $session->opened_at->format('d/m H:i') }}</td>
                        <td class="py-2 text-center">{{ $session->closed_at ? $session->closed_at->format('d/m H:i') : '-' }}</td>
                        <td class="py-2 text-right text-gray-500">₲ {{ format_pyg($session->opening_amount) }}</td>
                        <td class="py-2 text-right text-gray-500">₲ {{ format_pyg($session->calculated_amount) }}</td>
                        <td class="py-2 text-right font-bold">₲ {{ format_pyg($session->closing_amount) }}</td>
                        <td class="py-2 text-right font-bold {{ $session->difference < 0 ? 'text-red-600' : ($session->difference > 0 ? 'text-green-600' : 'text-gray-400') }}">
                            {{ $session->difference > 0 ? '+' : '' }}₲ {{ format_pyg($session->difference) }}
                        </td>
                        <td class="py-2 pl-2 italic text-gray-500 truncate max-w-xs">{{ Str::limit($session->notes, 30) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Signatures Section -->
    <div class="mt-16 grid grid-cols-2 gap-16 avoid-break">
        <div class="text-center pt-8 border-t border-gray-400">
            <p class="font-bold text-gray-800">Firma Cajero/a</p>
        </div>
        <div class="text-center pt-8 border-t border-gray-400">
            <p class="font-bold text-gray-800">Firma Supervisor</p>
        </div>
    </div>

    <div class="text-center mt-12 text-xs text-gray-400 no-print">
        <button onclick="window.close()" class="underline hover:text-gray-600">Cerrar Ventana</button>
    </div>

</body>
</html>
