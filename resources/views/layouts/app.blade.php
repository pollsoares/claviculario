<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Claviculário') }}</title>

    <!-- Bootstrap 5 CSS e Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

    <!-- Navbar Principal -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('loans.index') }}">
                <i class="bi bi-key-fill me-2"></i>Claviculário
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                @if (Auth::guard('controlador')->check())
                    <!-- Menu de Navegação Protegido -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('loans.index') ? 'active fw-bold' : '' }}" href="{{ route('loans.index') }}">
                                <i class="bi bi-arrow-repeat me-1"></i> Empréstimos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('keys.*') ? 'active fw-bold' : '' }}" href="{{ route('keys.index') }}">
                                <i class="bi bi-key me-1"></i> Chaves
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('controladores.*') ? 'active fw-bold' : '' }}" href="{{ route('controladores.index') }}">
                                <i class="bi bi-people me-1"></i> Controladores
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('loans.history') ? 'active fw-bold' : '' }}" href="{{ route('loans.history') }}">
                                <i class="bi bi-clock-history me-1"></i> Histórico
                            </a>
                        </li>
                    </ul>

                    <!-- Informações do Controlador Logado e Logout -->
                    <div class="d-flex align-items-center text-white gap-3">
                        <span class="small">
                            <i class="bi bi-person-circle me-1"></i>
                            <strong>{{ Auth::guard('controlador')->user()->nome }}</strong>
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light">
                                <i class="bi bi-box-arrow-right me-1"></i> Sair
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal da Página -->
    <main class="container flex-grow-1 pb-5">
        @yield('content')
    </main>

    <!-- Rodapé -->
    <footer class="footer bg-white border-top py-3 mt-auto text-center text-muted small">
        <div class="container">
            &copy; {{ date('Y') }} Claviculário - Sistema de Gestão e Controle de Chaves
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
