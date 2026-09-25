<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de movimientos</title>
    <style>
        * { font-family: Helvetica, Arial, sans-serif; }
        body { font-size: 11px; color: #222; }

        .header { margin-bottom: 14px; }
        .header h1 { font-size: 18px; color: #4c7a28; margin: 0 0 4px 0; }
        .header p { margin: 0; color: #666; font-size: 10px; }

        .filtros { margin-bottom: 14px; font-size: 10px; color: #444; }
        .filtros span {
            display: inline-block;
            background: #eef7e2;
            border-radius: 3px;
            padding: 2px 8px;
            margin: 0 4px 4px 0;
        }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: #4c7a28;
            color: #fff;
            text-align: left;
            padding: 5px 6px;
            font-size: 10px;
        }
        tbody td {
            padding: 5px 6px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
            vertical-align: top;
        }
        tbody tr:nth-child(even) { background: #f7f9f4; }

        .badge {
            padding: 1px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .badge-creado    { background: #dcf5e3; color: #1a7a3c; }
        .badge-editado   { background: #fdf1d0; color: #9a6b00; }
        .badge-eliminado { background: #fbe0e0; color: #a02222; }

        .cambio { margin-bottom: 2px; }
        .cambio .campo { color: #666; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Historial de movimientos</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i') }} &nbsp;|&nbsp; {{ $logs->count() }} registro(s)</p>
    </div>

    @if (count($filtrosTexto))
        <div class="filtros">
            <strong>Filtros aplicados:</strong><br>
            @foreach ($filtrosTexto as $f)
                <span>{{ $f }}</span>
            @endforeach
        </div>
    @endif

    <table>
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
                        @foreach ($log->changesList() as $cambio)
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
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#888; padding:16px;">
                        No hay movimientos con esos filtros.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
