<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Agenda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* =========================
           🎨 TEMAS COM DEGRADÊ
        ========================= */

        /* 💅 FEMININO */
        :root {
            --bg-gradient: linear-gradient(135deg, #000000, #1a1a1a, #ff4d88);
            --card-bg: #1a1a1a;

            --text-primary: #ff4d88;
            --text-secondary: #d4af37;

            --btn-main: linear-gradient(135deg, #ff4d88, #d4af37);
            --btn-hover: #ff4d88;
        }

        /* 💈 MASCULINO */
        [data-theme="masculino"] {
            --bg-gradient: linear-gradient(135deg, #000000, #1a1a1a, #0d47a1);
            --card-bg: #1a1a1a;

            --text-primary: #0d47a1;
            --text-secondary: #b71c1c;

            --btn-main: linear-gradient(135deg, #0d47a1, #b71c1c, #d4af37);
            --btn-hover: #0d47a1;
        }

        /* =========================
           BASE
        ========================= */

        body {
            background: var(--bg-gradient) !important;
            min-height: 100vh;
            color: white;
        }

        .navbar-custom {
            background: #000 !important;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        /* =========================
           TEXTOS
        ========================= */

        .form-label,
        h1, h2, h3, h4, h5,
        .fw-bold {
            color: var(--text-primary) !important;
        }

        /* =========================
           CARDS
        ========================= */

        .card,
        .custom-card-form,
        .custom-card-table {
            background: var(--card-bg) !important;
            border-radius: 16px !important;
            color: white !important;
            border: 1px solid rgba(255,255,255,0.05) !important;
        }

        /* =========================
           BOTÕES
        ========================= */

        .btn-save-custom,
        .btn-update-custom,
        .btn-edit-custom {
            background: var(--btn-main) !important;
            border: none !important;
            color: white !important;
            font-weight: bold !important;
            transition: 0.3s;
        }

        .btn-save-custom:hover,
        .btn-update-custom:hover,
        .btn-edit-custom:hover {
            background: var(--btn-hover) !important;
            transform: translateY(-2px);
        }

        .nav-link {
            color: rgba(255,255,255,0.7) !important;
        }

        .nav-link:hover {
            color: white !important;
        }

        .brand-first-word {
            color: white;
        }

        .brand-second-word {
            color: var(--text-secondary); /* dourado */
        }

    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">
            <span class="brand-first-word">SCHEDULE</span>
            <span class="brand-second-word">ONLINE</span>
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.index') }}">Início</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('agendamentos.index') }}">Agendamentos</a>
                </li>

                <li class="nav-item me-2">
                    <button id="theme-toggler" class="btn btn-sm btn-outline-light rounded-pill px-3">
                        💅 Feminino
                    </button>
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-light btn-sm">Sair</button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>

<main class="container">
    @yield('content')
</main>

<footer class="text-center py-3 mt-5" style="color: #aaa;">
    <small>&copy; 2026 Sistema de Agenda</small>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('theme-toggler');

    const temaSalvo = localStorage.getItem('tema') || 'feminino';
    aplicarTema(temaSalvo);

    button.addEventListener('click', function () {
        let temaAtual = document.documentElement.getAttribute('data-theme');

        if (temaAtual === 'masculino') {
            aplicarTema('feminino');
        } else {
            aplicarTema('masculino');
        }
    });

    function aplicarTema(tema) {
        if (tema === 'masculino') {
            document.documentElement.setAttribute('data-theme', 'masculino');
            button.innerHTML = "💈 Masculino";
            localStorage.setItem('tema', 'masculino');
        } else {
            document.documentElement.removeAttribute('data-theme');
            button.innerHTML = "💅 Feminino";
            localStorage.setItem('tema', 'feminino');
        }
    }
});
</script>

</body>
</html>
