@extends('layouts.app')

@section('title', 'Detalle de categoría')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>{{ $category->category_name }}</h1>
            <p>Detalle de la categoría y sus subcategorías.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="ac-card p-4 mb-4">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">Nombre</dt>
            <dd class="col-sm-9">{{ $category->category_name }}</dd>

            <dt class="col-sm-3 text-muted">Estado</dt>
            <dd class="col-sm-9">{{ $category->status->status_name ?? '—' }}</dd>
        </dl>
    </div>

    <div class="ac-card">
        <div class="p-3 border-bottom fw-semibold">Subcategorías ({{ $category->subCategories->count() }})</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($category->subCategories as $sub)
                        <tr>
                            <td class="text-muted">{{ $sub->id }}</td>
                            <td>{{ $sub->subcategory_name }}</td>
                            <td>{{ $sub->status->status_name ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Sin subcategorías registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection