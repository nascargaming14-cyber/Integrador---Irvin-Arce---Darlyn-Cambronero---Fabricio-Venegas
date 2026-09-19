@extends('layouts.app')

@section('title', 'Categorías')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1f2e">Categorías</h2>
        <p class="text-muted small mb-0">Listado de todas las categorías registradas</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nueva categoría
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

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
                @forelse ($categories as $category)
                    <tr>
                        <td class="ps-4">{{ $category->id }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->status->status_name ?? '—' }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('categories.edit', $category->id) }}"
                               class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta categoría?');">
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
                        <td colspan="4" class="text-center text-muted py-4">No hay categorías registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $categories->links('pagination::bootstrap-5') }}
</div>

@endsection