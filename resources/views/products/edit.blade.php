@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>Editar producto</h1>
            <p>Actualiza la información de <strong>{{ $product->product_name }}</strong>.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="ac-card p-4" style="max-width: 720px">
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="barcode" class="form-label">Código de barras</label>
                    <input type="text" name="barcode" id="barcode"
                           class="form-control ac-mono @error('barcode') is-invalid @enderror"
                           value="{{ old('barcode', $product->barcode) }}" maxlength="100" required autofocus>
                    @error('barcode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="product_name" class="form-label">Nombre del producto</label>
                    <input type="text" name="product_name" id="product_name"
                           class="form-control @error('product_name') is-invalid @enderror"
                           value="{{ old('product_name', $product->product_name) }}" maxlength="150" required>
                    @error('product_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="category_id" class="form-label">Categoría</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">Seleccione...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text">Filtra las subcategorías disponibles.</div>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="sub_category_id" class="form-label">Subcategoría</label>
                    <select name="sub_category_id" id="sub_category_id"
                            class="form-select @error('sub_category_id') is-invalid @enderror" required>
                        <option value="">Seleccione...</option>
                    </select>
                    @error('sub_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="unit_id" class="form-label">Unidad de medida</label>
                    <select name="unit_id" id="unit_id"
                            class="form-select @error('unit_id') is-invalid @enderror" required>
                        <option value="">Seleccione...</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="stock" class="form-label">Stock actual</label>
                    <div class="input-group">
                        <input type="number" step="0.01" min="0" name="stock" id="stock"
                               class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', $product->stock) }}">
                        <span class="input-group-text" id="stock_unit_label">unidad</span>
                    </div>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="minimum_stock" class="form-label">Stock mínimo</label>
                    <div class="input-group">
                        <input type="number" step="0.01" min="0" name="minimum_stock" id="minimum_stock"
                               class="form-control @error('minimum_stock') is-invalid @enderror"
                               value="{{ old('minimum_stock', $product->minimum_stock) }}">
                        <span class="input-group-text" id="minimum_stock_unit_label">unidad</span>
                    </div>
                    @error('minimum_stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price_buy" class="form-label">Precio de compra</label>
                    <div class="input-group">
                        <span class="input-group-text">₡</span>
                        <input type="number" step="0.01" min="0" name="price_buy" id="price_buy"
                               class="form-control @error('price_buy') is-invalid @enderror"
                               value="{{ old('price_buy', $product->price_buy) }}" required>
                    </div>
                    @error('price_buy')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="price_sale" class="form-label">Precio de venta</label>
                    <div class="input-group">
                        <span class="input-group-text">₡</span>
                        <input type="number" step="0.01" min="0" name="price_sale" id="price_sale"
                               class="form-control @error('price_sale') is-invalid @enderror"
                               value="{{ old('price_sale', $product->price_sale) }}" required>
                    </div>
                    @error('price_sale')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Proveedores</label>
                <div class="row">
                    @forelse ($suppliers as $supplier)
                        @php
                            $isChecked = in_array($supplier->id, old('supplier_ids', $product->suppliers->pluck('id')->toArray()));
                        @endphp
                        <div class="col-md-4 form-check">
                            <input type="checkbox" name="supplier_ids[]" value="{{ $supplier->id }}"
                                   class="form-check-input" id="supplier_{{ $supplier->id }}"
                                   {{ $isChecked ? 'checked' : '' }}>
                            <label class="form-check-label" for="supplier_{{ $supplier->id }}">
                                {{ $supplier->name }}
                            </label>
                        </div>
                    @empty
                        <p class="text-muted small">No hay proveedores registrados.</p>
                    @endforelse
                </div>
            </div>

            <div class="mb-4">
                <label for="status_id" class="form-label">Estado</label>
                <select name="status_id" id="status_id"
                        class="form-select @error('status_id') is-invalid @enderror" required>
                    <option value="">Seleccione un estado...</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}"
                            {{ old('status_id', $product->status_id) == $status->id ? 'selected' : '' }}>
                            {{ $status->status_name }}
                        </option>
                    @endforeach
                </select>
                @error('status_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-ac-primary">
                    <i class="bi bi-arrow-repeat me-1"></i> Actualizar
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    const subCategoryUnits = @json($subCategoryUnits);
    const categorySubcategories = @json(
        $subCategories->groupBy('category_id')->map(function ($group) {
            return $group->map(fn ($sub) => ['id' => $sub->id, 'name' => $sub->subcategory_name])->values();
        })
    );

    const allUnitOptions = Array.from(document.getElementById('unit_id').options);

    const categorySelect    = document.getElementById('category_id');
    const subCategorySelect = document.getElementById('sub_category_id');
    const unitSelect        = document.getElementById('unit_id');

    const stockUnitLabel        = document.getElementById('stock_unit_label');
    const minimumStockUnitLabel = document.getElementById('minimum_stock_unit_label');

    function updateStockUnitLabels() {
        const opt = unitSelect.options[unitSelect.selectedIndex];
        const label = (opt && opt.value) ? opt.textContent.trim() : 'unidad';
        stockUnitLabel.textContent = label;
        minimumStockUnitLabel.textContent = label;
    }

    function updateUnitOptions(selectedUnitId = null) {
        const subId = subCategorySelect.value;
        const allowed = subCategoryUnits[subId] || [];

        unitSelect.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = allowed.length ? 'Seleccione...' : 'Sin unidades configuradas para esta subcategoría';
        unitSelect.appendChild(placeholder);

        allUnitOptions.forEach(opt => {
            if (opt.value === '') return;
            if (allowed.includes(parseInt(opt.value))) {
                const clone = opt.cloneNode(true);
                if (selectedUnitId && parseInt(opt.value) === parseInt(selectedUnitId)) {
                    clone.selected = true;
                }
                unitSelect.appendChild(clone);
            }
        });

        // Si solo hay una unidad permitida y no había una ya seleccionada, se selecciona sola
        if (!selectedUnitId && unitSelect.options.length === 2) {
            unitSelect.selectedIndex = 1;
        }

        updateStockUnitLabels();
    }

    function updateSubCategoryOptions(selectedSubCategoryId = null, selectedUnitId = null) {
        const catId = categorySelect.value;
        const options = categorySubcategories[catId] || [];

        subCategorySelect.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = options.length ? 'Seleccione...' : 'Sin subcategorías para esta categoría';
        subCategorySelect.appendChild(placeholder);

        options.forEach(opt => {
            const el = document.createElement('option');
            el.value = opt.id;
            el.textContent = opt.name;
            if (selectedSubCategoryId && parseInt(opt.id) === parseInt(selectedSubCategoryId)) {
                el.selected = true;
            }
            subCategorySelect.appendChild(el);
        });

        updateUnitOptions(selectedUnitId);
    }

    categorySelect.addEventListener('change', () => updateSubCategoryOptions());
    subCategorySelect.addEventListener('change', () => updateUnitOptions());
    unitSelect.addEventListener('change', updateStockUnitLabels);

    // Valores iniciales: los del producto, o los de old() si hubo un error de validación
    const initialCategoryId    = '{{ old('category_id', $product->subCategory->category_id ?? '') }}';
    const initialSubCategoryId = '{{ old('sub_category_id', $product->sub_category_id) }}';
    const initialUnitId        = '{{ old('unit_id', $product->unit_id) }}';

    if (initialCategoryId) {
        categorySelect.value = initialCategoryId;
        updateSubCategoryOptions(initialSubCategoryId, initialUnitId);
    }

    updateStockUnitLabels();
</script>
@endpush
