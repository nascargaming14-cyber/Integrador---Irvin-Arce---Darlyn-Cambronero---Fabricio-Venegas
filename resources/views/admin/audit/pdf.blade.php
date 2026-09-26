<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de movimientos</title>
    <style>
        @page {
            margin: 28px 34px 90px 34px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #2b2f38;
            margin: 0;
            padding: 0;
        }

        .accent-bar {
            height: 6px;
            background: #3f5c22;
            width: 100%;
            margin-bottom: 22px;
        }

        /* ── Encabezado ── */
        table.header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.header-table td {
            vertical-align: top;
        }

        .logo {
            max-width: 190px;
            max-height: 80px;
            margin-bottom: 8px;
        }

        .logo-text {
            font-size: 26px;
            font-weight: bold;
            color: #3f5c22;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .logo-text .accent {
            color: #93c90f;
        }

        .logo-tagline {
            font-size: 8px;
            letter-spacing: 1.5px;
            color: #6b7280;
            text-transform: uppercase;
            margin: 0 0 10px 0;
        }

        .company-meta {
            font-size: 9.5px;
            color: #6b7280;
            line-height: 1.5;
        }

        .doc-box {
            text-align: right;
        }

        .doc-title {
            font-size: 20px;
            font-weight: bold;
            color: #3f5c22;
            margin: 0 0 6px 0;
            letter-spacing: 1px;
        }

        .doc-meta {
            font-size: 9.5px;
            color: #6b7280;
            margin-top: 4px;
            line-height: 1.6;
        }

        /* ── Filtros aplicados ── */
        .filtros-box {
            background: #f6f7f9;
            border-left: 3px solid #3f5c22;
            padding: 10px 16px;
            margin-bottom: 20px;
        }

        .filtros-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #6b7280;
            margin: 0 0 6px 0;
        }

        .filtro-pill {
            display: inline-block;
            background: #eef7d9;
            color: #4a6b1c;
            border-radius: 10px;
            padding: 3px 10px;
            font-size: 9px;
            font-weight: bold;
            margin: 0 5px 5px 0;
        }

        /* ── Tabla de movimientos ── */
        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        table.items-table thead th {
            background: #3f5c22;
            color: #ffffff;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 9px 10px;
            text-align: left;
        }

        table.items-table tbody td {
            padding: 9px 10px;
            font-size: 10px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        table.items-table tbody tr:nth-child(even) {
            background: #fafbfc;
        }

        .badge {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-creado    { background: #eef7d9; color: #4a6b1c; }
        .badge-editado   { background: #fdf1d0; color: #9a6b00; }
        .badge-eliminado { background: #fbe0e0; color: #a02222; }

        .cambio { margin-bottom: 2px; }
        .cambio .campo { color: #6b7280; }

        /* ── Pie de página fijo (igual que la factura) ── */
        .invoice-footer {
            position: fixed;
            bottom: -70px;
            left: 0;
            right: 0;
            text-align: center;
        }

        .footer-fineprint {
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    @php
        $companyName    = 'Servigrama S.A.';
        $companyAddress = 'San Pedro, Sarchí, Alajuela, Costa Rica';
        $companyPhones  = '+(506) 2454-1600 / +(506) 8317-2732';
        $companyEmails  = 'ventas@servigrama.com / cesped@servigrama.com';
        $logoPath = public_path('Imagenes/servigrama.png');
    @endphp

    {{-- ── Pie de página fijo: se repite igual en todas las páginas ── --}}
    <div class="invoice-footer">
        <div class="footer-fineprint">
            Documento generado electrónicamente por el sistema Servigrama.<br>
            {{ $companyName }} &nbsp;·&nbsp; {{ $companyPhones }} &nbsp;·&nbsp; {{ $companyEmails }}
        </div>
    </div>

    <div class="accent-bar"></div>

    <table class="header-table">
        <tr>
            <td style="width: 55%;">
                @if (file_exists($logoPath))
                    <img src="{{ $logoPath }}" class="logo" alt="{{ $companyName }}">
                @else
                    <p class="logo-text">ser<span class="accent">V</span>igrama</p>
                    <p class="logo-tagline">Césped y Follajes Sintéticos</p>
                @endif
                <div class="company-meta">
                    {{ $companyAddress }}<br>
                    Tel: {{ $companyPhones }}<br>
                    {{ $companyEmails }}
                </div>
            </td>
            <td class="doc-box" style="width: 45%;">
                <p class="doc-title">HISTORIAL DE MOVIMIENTOS</p>
                <div class="doc-meta">
                    Generado el {{ now()->format('d/m/Y') }}<br>
                    Hora: {{ now()->format('H:i') }}<br>
                    {{ $logs->count() }} registro(s)
                </div>
            </td>
        </tr>
    </table>

    @if (count($filtrosTexto))
        <div class="filtros-box">
            <p class="filtros-label">Filtros aplicados</p>
            @foreach ($filtrosTexto as $f)
                <span class="filtro-pill">{{ $f }}</span>
            @endforeach
        </div>
    @endif

    <table class="items-table">
        <thead>
            <tr>
                <th style="width:12%;">Fecha</th>
                <th style="width:12%;">Usuario</th>
                <th style="width:12%;">Módulo</th>
                <th style="width:14%;">Registro</th>
                <th style="width:10%;">Acción</th>
                <th>Cambios</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $log->user->user_name ?? 'Usuario eliminado' }}</td>
                    <td>{{ $log->moduleLabel() }}</td>
                    <td>{{ $log->record_label }}</td>
                    <td>
                        <span class="badge badge-{{ $log->action }}">
                            {{ ucfirst($log->action) }}
                        </span>
                    </td>
                    <td>
                        @forelse ($log->changesList() as $cambio)
                            <div class="cambio">
                                <span class="campo">{{ $cambio['label'] }}:</span>
                                @if ($log->action === 'editado')
                                    {{ $log->formatValue($cambio['before']) }} -&gt; <strong>{{ $log->formatValue($cambio['after']) }}</strong>
                                @elseif ($log->action === 'creado')
                                    {{ $log->formatValue($cambio['after']) }}
                                @else
                                    {{ $log->formatValue($cambio['before']) }}
                                @endif
                            </div>
                        @empty
                            <span style="color:#9ca3af;">—</span>
                        @endforelse
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#9ca3af; padding: 16px;">
                        No hay movimientos con esos filtros.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
