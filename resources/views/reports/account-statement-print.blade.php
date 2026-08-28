<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Cuenta - {{ $customer->name }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; }
        .info td { vertical-align: top; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th { background: #f8f9fa; text-align: left; padding: 10px; border-bottom: 2px solid #dee2e6; font-size: 12px; text-transform: uppercase; }
        .table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 12px; }
        .amount { text-align: right; font-family: 'Courier', monospace; }
        .total-box { margin-top: 30px; text-align: right; border-top: 2px solid #333; padding-top: 10px; }
        .total-label { font-weight: bold; font-size: 14px; text-transform: uppercase; }
        .total-amount { font-size: 20px; font-weight: 900; color: #d32f2f; }
        .footer { margin-top: 50px; text-align: center; font-size: 10px; color: #999; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="background: #fff3cd; padding: 10px; text-align: center; margin-bottom: 20px; border: 1px solid #ffeeba;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #333; color: #fff; border: none; cursor: pointer; border-radius: 4px;">Imprimir Estado de Cuenta</button>
    </div>

    <div class="header">
        <h1>ZonaShop - Estado de Cuenta</h1>
        <p>{{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td style="width: 50%;">
                    <strong>CLIENTE:</strong><br>
                    {{ $customer->name }}<br>
                    RUC/CI: {{ $customer->ruc }}<br>
                    TEL: {{ $customer->phone }}
                </td>
                <td style="text-align: right;">
                    <strong>EMPRESA:</strong><br>
                    ZonaShop S.A.<br>
                    Asunción, Paraguay
                </td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Concepto</th>
                <th class="amount">Débito (Venta)</th>
                <th class="amount">Crédito (Pago)</th>
                <th class="amount">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php $runningBalance = 0; @endphp
            @foreach($customer->transactions as $tx)
                @php 
                    if($tx->type === 'debit') $runningBalance += $tx->amount;
                    else $runningBalance -= $tx->amount;
                @endphp
                <tr>
                    <td>{{ $tx->created_at->format('d/m/Y') }}</td>
                    <td>{{ $tx->description }}</td>
                    <td class="amount">{{ $tx->type === 'debit' ? number_format($tx->amount, 0, ',', '.') : '—' }}</td>
                    <td class="amount">{{ $tx->type === 'credit' ? number_format($tx->amount, 0, ',', '.') : '—' }}</td>
                    <td class="amount" style="font-weight: bold;">{{ number_format($runningBalance, 0, ',', '.') }} ₲</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <span class="total-label">Saldo Pendiente Total:</span><br>
        <span class="total-amount">₲ {{ number_format($customer->balance, 0, ',', '.') }}</span>
    </div>

    <div class="footer">
        Este documento es un resumen de cuenta interna. No válido como factura legal.<br>
        ZonaShop - Sistema de Gestión Comercial
    </div>
</body>
</html>
