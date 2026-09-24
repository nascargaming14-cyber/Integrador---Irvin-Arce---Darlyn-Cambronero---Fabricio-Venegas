<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Servigrama') }} — @yield('title', 'Panel')</title>
    <link rel="icon" type="image/png" href="{{ asset('Imagenes/servigrama.png') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 240px;
            --sidebar-bg: #ffffff;
            --sidebar-hover: #eef7e2;
            --sidebar-active: #8cc63f;
            --sidebar-text: #4c7a28;
            --sidebar-text-active: #1f3a0f;
            --topbar-height: 56px;
            --accent: #8cc63f;
            --accent-dark: #4c7a28;
        }

        body {
            background: #f4f7f0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid #e5ecdb;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform 0.25s ease;
        }

        .sidebar-brand {
            height: auto;
            min-height: var(--topbar-height);
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #e5ecdb;
            text-decoration: none;
        }

        .sidebar-brand-logo-wrap {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 0.5rem 0;
        }

        .sidebar-brand-logo {
            max-width: 195px;
            width: 100%;
        }

        .sidebar-section-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(76,122,40,0.6);
            padding: 1.25rem 1.25rem 0.4rem;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 0.5rem 0.75rem 1rem;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(76,122,40,0.2); border-radius: 2px; }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.875rem;
            border-radius: 8px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
        }

        .nav-item-link i {
            font-size: 1.05rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            color: var(--accent);
        }

        .nav-item-link.active i {
            color: var(--sidebar-text-active);
        }

        .nav-item-link:hover {
            background: var(--sidebar-hover);
            color: var(--accent-dark);
        }

        .nav-item-link.active {
            background: var(--accent);
            color: var(--sidebar-text-active);
        }

        /* ── Topbar ── */
        #topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e5e9f2;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            z-index: 900;
            gap: 1rem;
        }

        .topbar-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1f2e;
            margin: 0;
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* ── Main content ── */
        #main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
        }

        .page-wrapper {
            padding: 1.75rem 2rem;
        }

        /* ── Cards ── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #e5e9f2;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.95rem;
            color: #1a1f2e;
        }

        /* ── Alerts ── */
        .alert { border: none; border-radius: 10px; }

        /* ── Tables ── */
        .table th {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7a9d;
            border-bottom: 2px solid #e5e9f2;
        }

        .table td { vertical-align: middle; font-size: 0.875rem; }

        /* ── Buttons ── */
        .btn { border-radius: 8px; font-size: 0.875rem; font-weight: 500; }
        .btn-primary { background: var(--accent); border-color: var(--accent); color: #1f3a0f; font-weight: 600; }
        .btn-primary:hover { background: var(--accent-dark); border-color: var(--accent-dark); color: #fff; }

        /* ── Mobile ── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #topbar, #main-content { left: 0; margin-left: 0; }
            .page-wrapper { padding: 1.25rem; }
        }
        /* ── Modo oscuro ── */
        body.dark-mode {
            background: #12161a;
            color: #e4ece0;
        }
        body.dark-mode #sidebar {
            background: #16220d;
            border-right-color: #223318;
        }
        body.dark-mode .sidebar-brand {
            border-bottom-color: rgba(255,255,255,0.08);
        }
        body.dark-mode .sidebar-section-label {
            color: rgba(140,198,63,0.55);
        }
        body.dark-mode .nav-item-link {
            color: #f2f5ee;
        }
        body.dark-mode .nav-item-link:hover {
            background: #223318;
            color: #eef2ea;
        }
        body.dark-mode .nav-item-link.active {
            background: var(--accent);
            color: #1f3a0f;
        }
        body.dark-mode .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(140,198,63,0.25);
        }
        body.dark-mode #topbar {
            background: #181f14;
            border-bottom-color: #263320;
        }
        body.dark-mode .topbar-title {
            color: #eef2ea;
        }
        body.dark-mode .theme-toggle-btn {
            border-color: #2a3a24;
            color: #cfe3c0;
        }
        body.dark-mode .card {
            background: #1c241a;
            color: #e4ece0;
        }
        body.dark-mode .card-header {
            background: #1c241a;
            border-bottom-color: #2a3a24;
            color: #eef2ea;
        }
        body.dark-mode .table th {
            color: #9db08c !important;
            border-bottom-color: #2a3a24 !important;
        }
        body.dark-mode .table td {
            color: #e4ece0 !important;
            border-bottom-color: #2a3a24;
        }
        body.dark-mode .table {
            --bs-table-bg: transparent;
            --bs-table-color: #e4ece0;
            --bs-table-striped-bg: #1c241a;
            --bs-table-hover-bg: #223318;
            --bs-table-border-color: #2a3a24;
        }
        body.dark-mode .text-muted {
            color: #9db08c !important;
        }
        body.dark-mode a:not(.btn) {
            color: var(--accent);
        }
        body.dark-mode hr {
            border-color: #2a3a24;
        }
        .page-link {
            color: var(--accent-dark);
        }
        .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
            color: #1f3a0f;
        }
        body.dark-mode .page-link {
            background-color: #1c241a;
            border-color: #2a3a24;
            color: #cfe3c0;
        }
        body.dark-mode .page-item.disabled .page-link {
            background-color: #1c241a;
            border-color: #2a3a24;
            color: #5a6a52;
        }
        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #1c241a;
            border-color: #2a3a24;
            color: #e4ece0;
        }
        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background-color: #1c241a;
            border-color: var(--accent);
            color: #e4ece0;
            box-shadow: 0 0 0 0.2rem rgba(140,198,63,0.25);
        }
        body.dark-mode .form-control::placeholder {
            color: #6b7a63;
        }
        body.dark-mode .form-label {
            color: #cfe3c0;
        }
        body.dark-mode .dropdown-menu {
            background-color: #1c241a;
            border-color: #2a3a24;
        }
        body.dark-mode .dropdown-item {
            color: #e4ece0;
        }
        body.dark-mode .dropdown-item:hover {
            background-color: #223318;
            color: #eef2ea;
        }
        body.dark-mode .btn-outline-secondary {
            border-color: #2a3a24;
            color: #cfe3c0;
        }
        body.dark-mode .btn-outline-secondary:hover {
            background-color: #223318;
            color: #eef2ea;
        }
        body.dark-mode .table-hover tbody tr:hover {
            background-color: #223318;
        }
        body.dark-mode .modal-content {
            background-color: #1c241a;
            color: #e4ece0;
        }
        .btn-outline-primary {
            color: var(--accent-dark);
            border-color: var(--accent-dark);
        }
        .btn-outline-primary:hover {
            background-color: var(--accent-dark);
            border-color: var(--accent-dark);
            color: #fff;
        }
        body.dark-mode .btn-outline-primary {
            color: var(--accent);
            border-color: var(--accent);
        }
        body.dark-mode .btn-outline-primary:hover {
            background-color: var(--accent);
            border-color: var(--accent);
            color: #1f3a0f;
        }
        body.dark-mode .btn-outline-dark,
        body.dark-mode .btn-outline-secondary,
        body.dark-mode .btn-secondary,
        body.dark-mode .btn-light {
            color: #eef2ea !important;
            border-color: #3a4a34 !important;
            background-color: #1c241a !important;
        }
        body.dark-mode .btn-outline-dark:hover,
        body.dark-mode .btn-outline-secondary:hover,
        body.dark-mode .btn-secondary:hover,
        body.dark-mode .btn-light:hover {
            background-color: #223318 !important;
            color: #ffffff !important;
        }
        body.dark-mode .btn:disabled,
        body.dark-mode .btn.disabled {
            color: #6b7a63 !important;
            border-color: #2a3a24 !important;
        }
        body.dark-mode .btn i {
            color: inherit;
        }
        body.dark-mode .ac-page-head h1 {
            color: #eef2ea !important;
        }
        body.dark-mode .ac-page-head p {
            color: #cfd9c8 !important;
        }
        body.dark-mode .ac-card {
            background: transparent !important;
            color: #e4ece0 !important;
            border: none !important;
            box-shadow: none !important;
        }
        body.dark-mode .btn-ac-primary {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: #1f3a0f !important;
        }
        body.dark-mode .btn-ac-primary:hover {
            background: var(--accent-dark) !important;
            border-color: var(--accent-dark) !important;
            color: #ffffff !important;
        }
        body.dark-mode dt, body.dark-mode dd {
            color: #e4ece0;
        }
        .text-primary {
            color: var(--accent-dark) !important;
        }
        body.dark-mode .text-primary {
            color: var(--accent) !important;
        }
        body.dark-mode .form-text {
            color: #9db08c !important;
        }
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3,
        body.dark-mode h4, body.dark-mode h5, body.dark-mode h6 {
            color: #eef2ea !important;
        }
        body.dark-mode p {
            color: #cfd9c8 !important;
        }

        /* ── Choices.js en modo oscuro ── */
        body.dark-mode .choices__inner {
            background-color: #1c241a !important;
            border-color: #2a3a24 !important;
            color: #e4ece0 !important;
        }
        body.dark-mode .choices__input {
            background-color: #1c241a !important;
            color: #e4ece0 !important;
        }
        body.dark-mode .choices__list--dropdown,
        body.dark-mode .choices__list[aria-expanded] {
            background-color: #1c241a !important;
            border-color: #2a3a24 !important;
        }
        body.dark-mode .choices__list--dropdown .choices__item,
        body.dark-mode .choices__list[aria-expanded] .choices__item {
            color: #e4ece0 !important;
        }
        body.dark-mode .choices__list--dropdown .choices__item--selectable.is-highlighted,
        body.dark-mode .choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
            background-color: #223318 !important;
            color: #eef2ea !important;
        }
        body.dark-mode .choices__list--multiple .choices__item {
            background-color: var(--accent-dark) !important;
            border-color: var(--accent-dark) !important;
            color: #ffffff !important;
        }
        body.dark-mode .choices__placeholder {
            color: #9db08c !important;
            opacity: 1 !important;
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- ══ TOASTS EN TIEMPO REAL ══ -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1200;" id="live-toast-container"></div>

<!-- ══ SIDEBAR ══ -->
<nav id="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <div class="sidebar-brand-logo-wrap">
            <img src="{{ asset('Imagenes/servigrama.png') }}"
                 data-light="{{ asset('Imagenes/servigrama.png') }}"
                 data-dark="{{ asset('Imagenes/servigrama blanco.png') }}"
                 alt="Servigrama" class="sidebar-brand-logo" id="sidebarLogo">
        </div>
    </a>

    <div class="sidebar-nav">
        <div class="sidebar-section-label">Principal</div>

        <a href="{{ route('dashboard') }}"
           class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Panel
        </a>

        @if(auth()->user()->canAccess('customers') || auth()->user()->canAccess('customers.view') || auth()->user()->canAccess('products') || auth()->user()->canAccess('products.view') || auth()->user()->canAccess('categories') || auth()->user()->canAccess('suppliers'))
        <div class="sidebar-section-label">Gestión</div>
        @endif

        @if(auth()->user()->canAccess('categories'))
            <a href="{{ route('categories.index') }}"
               class="nav-item-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tag"></i> Categorías
            </a>
        @endif

        @if(auth()->user()->canAccess('products') || auth()->user()->canAccess('products.view'))
            <a href="{{ route('subcategories.index') }}"
               class="nav-item-link {{ request()->routeIs('subcategories.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i> Subcategorías
            </a>
        @endif

        @if(auth()->user()->isAdmin())
            <a href="{{ route('units.index') }}"
               class="nav-item-link {{ request()->routeIs('units.*') ? 'active' : '' }}">
                <i class="bi bi-rulers"></i> Unidades de medida
            </a>
        @endif

        @if(auth()->user()->canAccess('products') || auth()->user()->canAccess('products.view'))
            <a href="{{ route('products.index') }}"
               class="nav-item-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="bi bi-box"></i> Productos
            </a>
        @endif

        @if(auth()->user()->canAccess('suppliers'))
            <a href="{{ route('suppliers.index') }}"
               class="nav-item-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i> Proveedores
            </a>
        @endif

        @if(auth()->user()->canAccess('customers') || auth()->user()->canAccess('customers.view'))
            <a href="{{ route('customers.index') }}"
               class="nav-item-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Clientes
            </a>
        @endif

        @if(auth()->user()->canAccess('orders') || auth()->user()->canAccess('orders.view'))
        <div class="sidebar-section-label">Ventas</div>
            <a href="{{ route('orders.index') }}"
               class="nav-item-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Órdenes
            </a>
        @endif

        @if(auth()->user()->canAccess('reports.sales') || auth()->user()->canAccess('reports.inventory'))
        <div class="sidebar-section-label">Reportes</div>
        @endif

        @if(auth()->user()->canAccess('reports.sales'))
            <a href="{{ route('reports.sales.form') }}"
               class="nav-item-link {{ request()->routeIs('reports.sales.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Reporte de Ventas
            </a>
        @endif

        @if(auth()->user()->canAccess('reports.inventory'))
            <a href="{{ route('reports.inventory.form') }}"
               class="nav-item-link {{ request()->routeIs('reports.inventory.*') ? 'active' : '' }}">
                <i class="bi bi-boxes"></i> Reporte de Inventario
            </a>
        @endif

        @if(auth()->user()->isAdmin())
        <div class="sidebar-section-label">Administración</div>
            <a href="{{ route('users.index') }}"
               class="nav-item-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i> Usuarios
            </a>
        @endif
    </div>
</nav>

<!-- ══ TOPBAR ══ -->
<header id="topbar">
    <button class="btn btn-sm d-md-none me-1" id="sidebar-toggle">
        <i class="bi bi-list fs-5"></i>
    </button>
    <h1 class="topbar-title">@yield('title', 'Panel')</h1>
    <div class="topbar-right">
        <button class="btn btn-sm rounded-circle border theme-toggle-btn" id="themeToggle"
                style="width:32px;height:32px;" title="Cambiar tema">
            <i class="bi bi-moon-stars" id="themeIcon"></i>
        </button>

        <span class="text-muted small d-none d-sm-inline">{{ auth()->user()->user_name }}</span>

        <div class="dropdown">
            <button class="btn btn-sm rounded-circle text-white border-0 dropdown-toggle"
                    style="width:32px;height:32px;font-size:0.8rem;font-weight:700;background:var(--accent-dark);"
                    data-bs-toggle="dropdown">
                {{ strtoupper(substr(auth()->user()->user_name, 0, 1)) }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <span class="dropdown-item-text small text-muted">
                        {{ auth()->user()->user_name }} — {{ auth()->user()->role->role_name ?? '' }}
                    </span>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

<!-- ══ CONTENIDO PRINCIPAL ══ -->
<main id="main-content">
    <div class="page-wrapper">

        @yield('content')
    </div>
</main>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle sidebar en móvil
    document.getElementById('sidebar-toggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('open');
    });

    // Modo oscuro
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const sidebarLogo = document.getElementById('sidebarLogo');

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.body.classList.add('dark-mode');
            sidebarLogo.src = sidebarLogo.dataset.dark;
            themeIcon.classList.remove('bi-moon-stars');
            themeIcon.classList.add('bi-sun');
        } else {
            document.body.classList.remove('dark-mode');
            sidebarLogo.src = sidebarLogo.dataset.light;
            themeIcon.classList.remove('bi-sun');
            themeIcon.classList.add('bi-moon-stars');
        }
    }

    applyTheme(localStorage.getItem('sv-theme') || 'light');

    themeToggle.addEventListener('click', () => {
        const newTheme = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
        localStorage.setItem('sv-theme', newTheme);
        applyTheme(newTheme);
    });
</script>

<!-- ══ NOTIFICACIONES EN TIEMPO REAL (Laravel Reverb) ══ -->
<script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script>
    // 👇 Activa el log de conexión de Pusher/Reverb en la consola del navegador.
    //    Sin esto, Pusher-js no imprime nada aunque conecte o falle en silencio.
    Pusher.logToConsole = true;

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: '{{ config('broadcasting.connections.reverb.key') }}',
        wsHost: '{{ config('broadcasting.connections.reverb.options.host') }}',
        wsPort: {{ config('broadcasting.connections.reverb.options.port') }},
        wssPort: {{ config('broadcasting.connections.reverb.options.port') }},
        forceTLS: false,
        enabledTransports: ['ws', 'wss'],
    });

    // 👇 Confirma en consola que el script llegó hasta aquí y que Echo se creó.
    console.log('✅ Echo inicializado:', window.Echo);

    function mostrarToast(titulo, mensaje, tipo = 'primary') {
        const iconos = { success: 'bi-check-circle-fill', warning: 'bi-exclamation-triangle-fill', primary: 'bi-info-circle-fill' };
        const colores = { success: 'text-success', warning: 'text-warning', primary: 'text-primary' };

        const toastEl = document.createElement('div');
        toastEl.className = 'toast align-items-center border-0 shadow-sm mb-2';
        toastEl.setAttribute('role', 'alert');
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${iconos[tipo] || iconos.primary} ${colores[tipo] || colores.primary} me-2"></i>
                    <strong>${titulo}</strong><br>
                    <span class="small text-muted">${mensaje}</span>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

        document.getElementById('live-toast-container').appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl, { delay: 6000 });
        toast.show();
        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    }

    Echo.channel('dashboard')
        .listen('.new-order', (e) => {
            mostrarToast('Nueva orden', `#${e.order_id} — ${e.customer_name} — ₡${Number(e.total).toLocaleString()}`, 'success');
        })
        .listen('.low-stock', (e) => {
            mostrarToast('Stock bajo', `${e.product_name}: quedan ${e.stock} (mínimo ${e.minimum_stock})`, 'warning');
        });
</script>

<!-- Si el navegador restaura la página desde caché (atrás/adelante), la recarga -->
<script>
    window.addEventListener('pageshow', function (event) {
        const nav = performance.getEntriesByType('navigation')[0];
        if (event.persisted || (nav && nav.type === 'back_forward')) {
            window.location.reload();
        }
    });
</script>

@stack('scripts')
</body>
</html>
