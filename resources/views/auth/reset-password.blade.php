<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva contraseña — Servigrama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sv-dark-green: #4c7a28;
            --sv-light-green: #8cc63f;
        }
        body {
            background: #f0f2f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding: 1rem 0;
        }
        .login-card {
            width: 100%;
            max-width: 380px;
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .brand-logo {
            display: block;
            max-width: 220px;
            margin: 0 auto 1.25rem;
        }
        .form-label.small { color: var(--sv-dark-green); font-weight: 600; }
        .form-control:focus {
            border-color: var(--sv-light-green);
            box-shadow: 0 0 0 0.2rem rgba(140, 198, 63, 0.25);
        }
        .toggle-pw {
            border-color: #ced4da;
            color: var(--sv-dark-green);
        }
        .toggle-pw:hover, .toggle-pw:focus {
            background: var(--sv-light-green);
            border-color: var(--sv-light-green);
            color: #1f3a0f;
        }
        .btn-primary { background: var(--sv-light-green); border-color: var(--sv-light-green); color: #1f3a0f; font-weight: 600; }
        .btn-primary:hover { background: var(--sv-dark-green); border-color: var(--sv-dark-green); color: #fff; }
        .link-sv { color: var(--sv-dark-green); text-decoration: none; }
        .link-sv:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card login-card p-4">
        <img src="{{ asset('Imagenes/servigrama.png') }}" alt="Servigrama" class="brand-logo">
        <p class="text-center text-muted small mb-4">Crea tu nueva contraseña</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label class="form-label small">Correo electrónico</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label small">Nueva contraseña</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control"
                           minlength="8" required autofocus>
                    <button type="button" class="btn btn-outline-secondary toggle-pw" data-target="password" tabindex="-1">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="form-text">Mínimo 8 caracteres.</div>
            </div>

            <div class="mb-3">
                <label class="form-label small">Confirmar contraseña</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                           minlength="8" required>
                    <button type="button" class="btn btn-outline-secondary toggle-pw" data-target="password_confirmation" tabindex="-1">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Guardar contraseña</button>

            <a href="{{ route('login') }}" class="link-sv d-block text-center small mt-3">
                Volver al inicio de sesión
            </a>
        </form>
    </div>

    <script>
        document.querySelectorAll('.toggle-pw').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const input = document.getElementById(btn.dataset.target);
                const icon = btn.querySelector('i');
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>
</html>
