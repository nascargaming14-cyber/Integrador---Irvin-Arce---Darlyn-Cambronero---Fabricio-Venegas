<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — Servigrama</title>
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
        #togglePassword {
            border-color: #ced4da;
            color: var(--sv-dark-green);
        }
        #togglePassword:hover, #togglePassword:focus {
            background: var(--sv-light-green);
            border-color: var(--sv-light-green);
            color: #1f3a0f;
        }
        .form-check-input:checked {
            background-color: var(--sv-light-green);
            border-color: var(--sv-light-green);
        }
        .btn-primary { background: var(--sv-light-green); border-color: var(--sv-light-green); color: #1f3a0f; font-weight: 600; }
        .btn-primary:hover { background: var(--sv-dark-green); border-color: var(--sv-dark-green); color: #fff; }
    </style>
</head>
<body>
    <div class="card login-card p-4">
        <img src="{{ asset('Imagenes/servigrama.png') }}" alt="Servigrama" class="brand-logo">
        <p class="text-center text-muted small mb-4">Inicia sesión para continuar</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.attempt') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label small">Correo electrónico</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label small">Contraseña</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword" tabindex="-1">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small" for="remember">Recordarme</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
