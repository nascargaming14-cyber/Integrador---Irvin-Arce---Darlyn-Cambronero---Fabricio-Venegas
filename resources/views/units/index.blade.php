@extends('layouts.app')

@section('title', 'Unidades de medida')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1f2e">Unidades de medida</h2>
        <p class="text-muted small mb-0">Listado de todas las unidades de medida registradas</p>
    </div>
    <a href="{{ route('units.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nueva unidad
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($units as $unit)
                    <tr>
                        <td class="ps-4">{{ $unit->id }}</td>
                        <td>{{ $unit->unit_name }}</td>
                        <td>{{ $unit->status->status_name ?? '—' }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('units.edit', $unit->id) }}"
                               class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('units.destroy', $unit->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta unidad de medida?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No hay unidades de medida registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $units->links() }}
</div>

@endsection
