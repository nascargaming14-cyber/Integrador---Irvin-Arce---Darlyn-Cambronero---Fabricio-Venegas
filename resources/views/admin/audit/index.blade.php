@extends('layouts.app')

@section('title', 'Historial')

@section('content')

    <h1 class="fw-bold mb-1" style="font-size:1.6rem;">Historial de movimientos</h1>
    <p class="text-muted mb-4">Registro de quién creó, editó o eliminó información en el sistema.</p>

    {{-- ══ Filtros ══ --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('audit.index') }}" class="row g-3">

                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted mb-1">Módulo</label>
                    <select name="module" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        @foreach ($modules as $key => $label)
                            <option value="{{ $key }}" @selected(request('module') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted mb-1">Acción</label>
                    <select name="action" class="form-select form-select-sm">
                        <option value="">Todas</option>
                        @foreach ($actions as $key => $label)
                            <option value="{{ $key }}" @selected(request('action') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted mb-1">Usuario</label>
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" @selected((string) request('user_id') === (string) $u->id)>
                                {{ $u->user_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted mb-1">Desde</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control form-control-sm">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted mb-1">Hasta</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control form-control-sm">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted mb-1">Buscar registro</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ej: Césped Amarillo" class="form-control form-control-sm">
                </div>

                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-sm text-white" style="background:#4c7a28;">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    <a href="{{ route('audit.index') }}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
                    <a href="{{ route('audit.pdf') }}?{{ http_build_query(request()->query()) }}"
                       target="_blank"
                       class="btn btn-sm btn-outline-danger ms-auto">
                        <i class="bi bi-file-earmark-pdf"></i> Imprimir PDF
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ══ Tabla ══ --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">Fecha</th>
                            <th>Usuario</th>
                            <th>Módulo</th>
                            <th>Registro</th>
                            <th>Acción</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td class="ps-3 text-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $log->user->user_name ?? 'Usuario eliminado' }}</td>
                                <td>{{ $log->moduleLabel() }}</td>
                                <td>{{ $log->record_label }}</td>
                                <td>
                                    @if ($log->action === 'creado')
                                        <span class="badge bg-success-subtle text-success">Creado</span>
                                    @elseif ($log->action === 'editado')
                                        <span class="badge bg-warning-subtle text-warning">Editado</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($log->before || $log->after)
                                        <button type="button" class="btn btn-sm btn-link p-0"
                                                style="color:#4c7a28;"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#audit-{{ $log->id }}">
                                            Ver cambios
                                        </button>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($log->before || $log->after)
                                <tr class="collapse" id="audit-{{ $log->id }}">
                                    <td colspan="6" class="bg-light">
                                        <div class="p-2">
                                            <table class="table table-sm mb-0 bg-white">
                                                <tbody>
                                                    @foreach ($log->changesList() as $cambio)
                                                        <tr>
                                                            <td class="text-muted" style="width:220px;">{{ $cambio['label'] }}</td>
                                                            <td>
                                                                @if ($log->action === 'editado')
                                                                    {{ $log->formatValue($cambio['before']) }}
                                                                    <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                                                    <strong>{{ $log->formatValue($cambio['after']) }}</strong>
                                                                @elseif ($log->action === 'creado')
                                                                    {{ $log->formatValue($cambio['after']) }}
                                                                @else
                                                                    {{ $log->formatValue($cambio['before']) }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No hay movimientos con esos filtros.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $logs->links() }}
    </div>

@endsection
