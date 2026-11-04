@extends('layouts.app')

@section('title', 'Calendario')

@php
    \Carbon\Carbon::setLocale('es');
@endphp

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <h2 class="mb-0 text-capitalize">{{ \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}</h2>

    <div class="d-flex gap-2">
        <a href="{{ route('calendar.index', ['month' => $start->copy()->subMonth()->format('Y-m')]) }}"
           class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-chevron-left"></i> Mes anterior
        </a>
        <a href="{{ route('calendar.index', ['month' => now()->format('Y-m')]) }}"
           class="btn btn-outline-secondary btn-sm">Hoy</a>
        <a href="{{ route('calendar.index', ['month' => $start->copy()->addMonth()->format('Y-m')]) }}"
           class="btn btn-outline-secondary btn-sm">
            Mes siguiente <i class="bi bi-chevron-right"></i>
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-body p-2 p-md-3">
        <table class="table table-bordered align-top mb-0" style="table-layout: fixed;">
            <thead>
                <tr class="text-center">
                    @foreach(['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'] as $dayName)
                        <th class="small text-muted fw-semibold">{{ $dayName }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($weeks as $week)
                <tr>
                    @foreach($week as $day)
                        @php
                            $dateStr = $day->toDateString();
                            $isOtherMonth = $day->month !== $start->month;
                            $dayJobs = $jobs->get($dateStr, collect());
                        @endphp
                        <td class="p-1 align-top {{ $isOtherMonth ? 'bg-light' : '' }}" style="height: 150px;">
                            <div class="d-flex justify-content-end mb-1">
                                <span class="badge rounded-pill {{ $isOtherMonth ? 'bg-secondary' : 'bg-success' }}">
                                    {{ $day->day }}
                                </span>
                            </div>

                            @foreach($crews as $crew)
                                @php $job = $dayJobs->firstWhere('crew_id', $crew->id); @endphp

                                <button type="button"
                                    class="btn btn-sm w-100 text-start d-flex align-items-center gap-1 mb-1 slot-btn {{ $job ? 'border' : 'border border-dashed text-muted' }}"
                                    style="font-size: 0.72rem; padding: 2px 6px;"
                                    data-date="{{ $dateStr }}"
                                    data-crew-id="{{ $crew->id }}"
                                    data-crew-code="{{ $crew->label }}"
                                    data-crew-name="{{ $crew->name }}"
                                    data-job-id="{{ $job->id ?? '' }}"
                                    data-client="{{ $job->client_name ?? '' }}"
                                    data-location="{{ $job->location ?? '' }}"
                                    data-area="{{ $job->area_m2 ?? '' }}"
                                    data-material="{{ $job->product->product_name ?? '' }}"
                                    data-product-id="{{ $job->product_id ?? '' }}"
                                    data-notes="{{ $job->notes ?? '' }}"
                                    data-completed="{{ $job && !is_null($job->completed) ? ($job->completed ? '1' : '0') : '' }}"
                                    data-confirmed="{{ $job && $job->confirmed ? '1' : '0' }}"
                                    data-stock-deducted="{{ $job && $job->stock_deducted ? '1' : '0' }}"
                                    data-confirmed-by="{{ $job->confirmedBy->user_name ?? '' }}">
                                    <strong>{{ $crew->label }}</strong>
                                    <span class="text-truncate">{{ $job->client_name ?? '' }}</span>
                                    @if($job && !is_null($job->completed))
                                        <i class="bi {{ $job->completed ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }} ms-auto"></i>
                                    @endif
                                </button>
                            @endforeach
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ══ MODAL: DETALLE DE TRABAJO + CONFIRMACIÓN ══ -->
<div class="modal fade" id="jobModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobModalTitle">Cuadrilla</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div id="lockedBanner" class="alert alert-secondary d-none">
                    <i class="bi bi-lock-fill"></i> Este trabajo ya está <strong>confirmado y completado</strong>. Solo se puede ver, no editar.
                </div>

                <!-- Datos del trabajo -->
                <form id="jobForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="jobFormMethod" value="POST">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small">Cliente</label>
                            <input type="text" name="client_name" id="jobClient" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Ubicación</label>
                            <input type="text" name="location" id="jobLocation" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Cantidad</label>
                            <div class="input-group input-group-sm">
                                <input type="number" step="0.01" name="area_m2" id="jobArea" class="form-control form-control-sm">
                                <span class="input-group-text" id="jobAreaUnit">—</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small">Material (producto)</label>
                            <select name="product_id" id="jobMaterial" class="form-select form-select-sm">
                                <option value="">Seleccione un producto...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-unit="{{ $product->unitMeasurement->unit_name ?? '' }}">{{ $product->product_name }} (stock: {{ $product->stock }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Notas</label>
                            <textarea name="notes" id="jobNotes" class="form-control form-control-sm" rows="2"></textarea>
                        </div>
                        <div class="col-12" id="moveWrap" style="display:none;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="moveToggle">
                                <label class="form-check-label small" for="moveToggle">Mover este trabajo a otro día</label>
                            </div>
                            <div class="mt-1 d-none" id="moveDateWrap" style="max-width: 220px;">
                                <input type="date" name="move_to_date" id="moveDateInput" class="form-control form-control-sm">
                                <div class="form-text" style="font-size: 0.7rem;">Se mueve con el cliente, cantidad, material y notas intactos. Si esa cuadrilla ya tiene un trabajo ese día, no se podrá mover.</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" id="jobDeleteBtn" class="btn btn-sm btn-outline-danger d-none">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary">Guardar trabajo</button>
                    </div>
                </form>

                <hr>

                <!-- Estado (pendiente/completado/no completado) -->
                <div id="statusSection" class="d-none">
                    <label class="form-label small fw-semibold">Estado del trabajo</label>
                    <form id="statusForm" method="POST" class="d-flex gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="completed" id="statusSelect" class="form-select form-select-sm w-auto">
                            <option value="">Pendiente</option>
                            <option value="1">Completado</option>
                            <option value="0">No completado</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Actualizar estado</button>
                    </form>
                </div>

                <hr id="confirmDivider" class="d-none">

                <!-- Cuadro de Confirmación -->
                <div id="confirmSection" class="d-none p-3 rounded" style="background: var(--sidebar-hover);">
                    <h6 class="fw-bold">Confirmación</h6>
                    <p class="small text-muted mb-2" id="confirmCurrentState"></p>

                    <form id="confirmForm" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small">¿Este trabajo está confirmado?</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="confirmed" id="confirmYes" value="1" required>
                                <label class="form-check-label" for="confirmYes">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="confirmed" id="confirmNo" value="0" required>
                                <label class="form-check-label" for="confirmNo">No</label>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Nota: si marca "Sí", confirma que el cliente y superiores autorizaron la fecha y el pago/adelanto correspondiente.</label>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small">Agente</label>
                                @if($isAdmin)
                                    <select name="agent_id" id="confirmAgent" class="form-select form-select-sm" required>
                                        <option value="" disabled selected>Seleccione...</option>
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}">{{ $agent->user_name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" class="form-control form-control-sm" value="{{ auth()->user()->user_name }}" disabled>
                                    <input type="hidden" name="agent_id" value="{{ auth()->id() }}">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">PIN</label>
                                <input type="password" name="pin" inputmode="numeric" pattern="\d{4}" maxlength="4"
                                       class="form-control form-control-sm" placeholder="••••" required>
                            </div>
                        </div>
                        <div class="text-end mt-2">
                            <button type="submit" class="btn btn-sm btn-primary">Confirmar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const jobModalEl = document.getElementById('jobModal');
    const jobModal = new bootstrap.Modal(jobModalEl);

    // Plantillas de rutas: se reemplaza __ID__ por el id real del trabajo con JS.
    const storeUrl        = "{{ route('calendar.store') }}";
    const updateUrlTpl    = "{{ route('calendar.update', ['calendarJob' => '__ID__']) }}";
    const statusUrlTpl    = "{{ route('calendar.update-status', ['calendarJob' => '__ID__']) }}";
    const confirmUrlTpl   = "{{ route('calendar.confirm', ['calendarJob' => '__ID__']) }}";
    const destroyUrlTpl   = "{{ route('calendar.destroy', ['calendarJob' => '__ID__']) }}";

    const jobForm       = document.getElementById('jobForm');
    const jobFormMethod = document.getElementById('jobFormMethod');
    const statusForm    = document.getElementById('statusForm');
    const confirmForm   = document.getElementById('confirmForm');
    const deleteBtn     = document.getElementById('jobDeleteBtn');
    const jobMaterial   = document.getElementById('jobMaterial');
    const jobAreaUnit   = document.getElementById('jobAreaUnit');
    const moveWrap      = document.getElementById('moveWrap');
    const moveToggle    = document.getElementById('moveToggle');
    const moveDateWrap  = document.getElementById('moveDateWrap');
    const moveDateInput = document.getElementById('moveDateInput');
    const lockedBanner  = document.getElementById('lockedBanner');

    // Actualiza la etiqueta de unidad (m², saco, unidad, etc.) según el producto elegido
    function updateAreaUnit() {
        const opt = jobMaterial.options[jobMaterial.selectedIndex];
        jobAreaUnit.textContent = (opt && opt.dataset.unit) ? opt.dataset.unit : '—';
    }
    jobMaterial.addEventListener('change', updateAreaUnit);

    moveToggle.addEventListener('change', () => {
        moveDateWrap.classList.toggle('d-none', !moveToggle.checked);
    });

    // Habilita/deshabilita todos los campos y botones del modal
    function setFormsLocked(locked) {
        [jobForm, statusForm, confirmForm].forEach(form => {
            form.querySelectorAll('input, select, textarea, button').forEach(el => {
                el.disabled = locked;
            });
        });
        deleteBtn.disabled = locked;
        lockedBanner.classList.toggle('d-none', !locked);
    }

    document.querySelectorAll('.slot-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const jobId  = btn.dataset.jobId;
            const locked = jobId && btn.dataset.confirmed === '1' && btn.dataset.completed === '1';

            document.getElementById('jobModalTitle').textContent =
                'Cuadrilla ' + btn.dataset.crewCode + (btn.dataset.crewName ? ' — ' + btn.dataset.crewName : '') +
                ' · ' + btn.dataset.date;

            document.getElementById('jobClient').value   = btn.dataset.client || '';
            document.getElementById('jobLocation').value = btn.dataset.location || '';
            document.getElementById('jobArea').value     = btn.dataset.area || '';
            jobMaterial.value = btn.dataset.productId || '';
            updateAreaUnit();
            document.getElementById('jobNotes').value    = btn.dataset.notes || '';

            // Reiniciar el bloque de "mover a otro día"
            moveToggle.checked = false;
            moveDateWrap.classList.add('d-none');
            moveDateInput.value = btn.dataset.date || '';

            // Campos ocultos necesarios para crear (solo si es trabajo nuevo)
            [...jobForm.querySelectorAll('input[name="crew_id"], input[name="work_date"]')].forEach(el => el.remove());
            const crewInput = document.createElement('input');
            crewInput.type = 'hidden'; crewInput.name = 'crew_id'; crewInput.value = btn.dataset.crewId;
            const dateInput = document.createElement('input');
            dateInput.type = 'hidden'; dateInput.name = 'work_date'; dateInput.value = btn.dataset.date;
            jobForm.appendChild(crewInput);
            jobForm.appendChild(dateInput);

            const statusSection  = document.getElementById('statusSection');
            const confirmSection = document.getElementById('confirmSection');
            const confirmDivider = document.getElementById('confirmDivider');

            if (jobId) {
                jobForm.action = updateUrlTpl.replace('__ID__', jobId);
                jobFormMethod.value = 'PUT';

                moveWrap.style.display = '';

                statusForm.action = statusUrlTpl.replace('__ID__', jobId);
                document.getElementById('statusSelect').value = btn.dataset.completed || '';
            const completadoOption = document.querySelector('#statusSelect option[value="1"]');
            completadoOption.disabled = btn.dataset.confirmed !== '1';
            completadoOption.title = completadoOption.disabled ? 'Primero debes confirmar el trabajo' : '';
                statusSection.classList.remove('d-none');

                confirmForm.action = confirmUrlTpl.replace('__ID__', jobId);
                const state = btn.dataset.confirmed === '1'
                    ? ('Confirmado' + (btn.dataset.confirmedBy ? ' por ' + btn.dataset.confirmedBy : ''))
                    : 'Aún no confirmado';
                document.getElementById('confirmCurrentState').textContent = 'Estado actual: ' + state;
                confirmSection.classList.remove('d-none');
                confirmDivider.classList.remove('d-none');

                deleteBtn.classList.remove('d-none');
                deleteBtn.onclick = () => {
                    if (confirm('¿Eliminar este trabajo de la pizarra?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = destroyUrlTpl.replace('__ID__', jobId);
                        form.innerHTML = '@csrf @method("DELETE")';
                        document.body.appendChild(form);
                        form.submit();
                    }
                };
            } else {
                jobForm.action = storeUrl;
                jobFormMethod.value = 'POST';
                moveWrap.style.display = 'none';
                statusSection.classList.add('d-none');
                confirmSection.classList.add('d-none');
                confirmDivider.classList.add('d-none');
                deleteBtn.classList.add('d-none');
            }

            setFormsLocked(locked);
            jobModal.show();
        });
    });
})();
</script>
@endpush
