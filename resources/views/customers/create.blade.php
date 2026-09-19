@extends('layouts.app')

@section('title', 'Nuevo cliente')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>Nuevo cliente</h1>
            <p>Registra un nuevo cliente.</p>
        </div>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="ac-card p-4" style="max-width: 640px">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="customer_name" class="form-label">Nombre completo</label>
                <input type="text" name="customer_name" id="customer_name"
                       class="form-control @error('customer_name') is-invalid @enderror"
                       value="{{ old('customer_name') }}" maxlength="150" required autofocus>
                @error('customer_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="country" class="form-label">País</label>
                    <select name="country" id="country" class="form-select @error('country') is-invalid @enderror">
                        <option value="">Seleccione un país...</option>
                        <option value="CR" {{ old('country') == 'CR' ? 'selected' : '' }}>Costa Rica</option>
                        <option value="MX" {{ old('country') == 'MX' ? 'selected' : '' }}>México</option>
                        <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>Estados Unidos</option>
                        <option value="GT" {{ old('country') == 'GT' ? 'selected' : '' }}>Guatemala</option>
                        <option value="HN" {{ old('country') == 'HN' ? 'selected' : '' }}>Honduras</option>
                        <option value="SV" {{ old('country') == 'SV' ? 'selected' : '' }}>El Salvador</option>
                        <option value="NI" {{ old('country') == 'NI' ? 'selected' : '' }}>Nicaragua</option>
                        <option value="PA" {{ old('country') == 'PA' ? 'selected' : '' }}>Panamá</option>
                        <option value="CO" {{ old('country') == 'CO' ? 'selected' : '' }}>Colombia</option>
                        <option value="VE" {{ old('country') == 'VE' ? 'selected' : '' }}>Venezuela</option>
                        <option value="EC" {{ old('country') == 'EC' ? 'selected' : '' }}>Ecuador</option>
                        <option value="PE" {{ old('country') == 'PE' ? 'selected' : '' }}>Perú</option>
                        <option value="BO" {{ old('country') == 'BO' ? 'selected' : '' }}>Bolivia</option>
                        <option value="CL" {{ old('country') == 'CL' ? 'selected' : '' }}>Chile</option>
                        <option value="AR" {{ old('country') == 'AR' ? 'selected' : '' }}>Argentina</option>
                        <option value="UY" {{ old('country') == 'UY' ? 'selected' : '' }}>Uruguay</option>
                        <option value="PY" {{ old('country') == 'PY' ? 'selected' : '' }}>Paraguay</option>
                        <option value="BR" {{ old('country') == 'BR' ? 'selected' : '' }}>Brasil</option>
                        <option value="ES" {{ old('country') == 'ES' ? 'selected' : '' }}>España</option>
                        <option value="DO" {{ old('country') == 'DO' ? 'selected' : '' }}>República Dominicana</option>
                        <option value="CU" {{ old('country') == 'CU' ? 'selected' : '' }}>Cuba</option>
                    </select>
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="id_type" class="form-label">Tipo de identificación</label>
                    <select name="id_type" id="id_type" class="form-select @error('id_type') is-invalid @enderror">
                        <option value="fisica" {{ old('id_type', 'fisica') == 'fisica' ? 'selected' : '' }}>Persona física</option>
                        <option value="juridica" {{ old('id_type') == 'juridica' ? 'selected' : '' }}>Persona jurídica</option>
                    </select>
                    @error('id_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="dni" class="form-label">Cédula / DNI</label>
                    <input type="text" name="dni" id="dni"
                           class="form-control ac-mono @error('dni') is-invalid @enderror"
                           value="{{ old('dni') }}" inputmode="numeric" maxlength="16">
                    <div class="form-text" id="dni-hint">Máximo 16 caracteres (persona o jurídica).</div>
                    @error('dni')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">Teléfono</label>
                    <input type="text" name="telephone" id="telephone"
                           class="form-control @error('telephone') is-invalid @enderror"
                           value="{{ old('telephone') }}" inputmode="numeric" maxlength="8" pattern="\d{8}">
                    <div class="form-text" id="telephone-hint">Debe tener 8 dígitos.</div>
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" maxlength="150">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status_id" class="form-label">Estado</label>
                <select name="status_id" id="status_id"
                        class="form-select @error('status_id') is-invalid @enderror" required>
                    <option value="">Seleccione un estado...</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
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
                    <i class="bi bi-save me-1"></i> Guardar
                </button>
                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Costa Rica distingue física (9) de jurídica (10); el resto de
    // países usa un solo máximo porque no tenemos el formato jurídico confirmado.
    const dniMaxLength = {
        CR: { fisica: 9, juridica: 10 },
        MX: 18, US: 9, GT: 13, HN: 13, SV: 14, NI: 14, PA: 13,
        CO: 10, VE: 10, EC: 13, PE: 11, BO: 10, CL: 9, AR: 11, UY: 12,
        PY: 8, BR: 14, ES: 9, DO: 11, CU: 11,
    };
    const DEFAULT_DNI_MAX = 16;

    const phoneDigits = {
        CR: 8, MX: 10, US: 10, GT: 8, HN: 8, SV: 8, NI: 8, PA: 8,
        CO: 10, VE: 10, EC: 9, PE: 9, BO: 8, CL: 9, AR: 10, UY: 9,
        PY: 9, BR: 11, ES: 9, DO: 10, CU: 8,
    };
    const DEFAULT_PHONE_DIGITS = 8;

    const countrySelect = document.getElementById('country');
    const idTypeSelect = document.getElementById('id_type');
    const dniInput = document.getElementById('dni');
    const dniHint = document.getElementById('dni-hint');
    const telephoneInput = document.getElementById('telephone');
    const telephoneHint = document.getElementById('telephone-hint');

    function updateDniLimit() {
        const code = countrySelect.value;
        let max = dniMaxLength[code] ?? DEFAULT_DNI_MAX;
        if (typeof max === 'object') {
            max = max[idTypeSelect.value] ?? Math.max(...Object.values(max));
        }
        dniInput.setAttribute('maxlength', max);
        dniHint.textContent = `Máximo ${max} caracteres para el país y tipo seleccionados.`;
        if (dniInput.value.length > max) {
            dniInput.value = dniInput.value.slice(0, max);
        }
    }

    function updatePhoneLimit() {
        const code = countrySelect.value;
        const digits = phoneDigits[code] ?? DEFAULT_PHONE_DIGITS;
        telephoneInput.setAttribute('maxlength', digits);
        telephoneInput.setAttribute('pattern', `\\d{${digits}}`);
        telephoneHint.textContent = `Debe tener ${digits} dígitos para el país seleccionado.`;
        if (telephoneInput.value.length > digits) {
            telephoneInput.value = telephoneInput.value.slice(0, digits);
        }
    }

    countrySelect.addEventListener('change', () => { updateDniLimit(); updatePhoneLimit(); });
    idTypeSelect.addEventListener('change', updateDniLimit);
    updateDniLimit();
    updatePhoneLimit();

    telephoneInput.addEventListener('input', function () {
        const max = parseInt(this.getAttribute('maxlength'), 10);
        this.value = this.value.replace(/\D/g, '').slice(0, max);
    });

    dniInput.addEventListener('input', function () {
        const max = parseInt(this.getAttribute('maxlength'), 10);
        this.value = this.value.replace(/\D/g, '').slice(0, max);
    });
</script>
@endpush
