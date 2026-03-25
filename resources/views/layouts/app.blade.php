<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Online | Clean & Premium</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* =========================================================
           PALETA CLEAN: CONTRASTE DE PRETO, BRANCO E ACENTO
           ========================================================= */
        :root {
            --bg-body: #fdfdfd;       /* Branco Puro */
            --nav-bg: #121212;        /* Grafite Escuro (Sóbrio) */
            --accent: #007bff;        /* Azul Moderno */
            --text-main: #1a1a1a;     /* Preto para leitura perfeita */
            --card-shadow: rgba(0, 0, 0, 0.08);
        }

        [data-theme="summer"] {
            --bg-body: #fffafa;       /* Branco com leve toque rosado */
            --nav-bg: #432837;        /* Rosé Escuro Profundo */
            --accent: #ff758c;        /* Rosa Quartz */
            --text-main: #2d1e26;
        }

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            transition: 0.3s ease-in-out;
        }

        /* NAVBAR FLUTUANTE E ARREDONDADA */
        .navbar-custom {
            background-color: var(--nav-bg) !important;
            margin: 20px auto;
            width: 90%;
            border-radius: 60px; /* Bordas de cápsula */
            padding: 10px 35px;
            box-shadow: 0 10px 30px var(--card-shadow);
            border: none;
        }

        .navbar-brand {
            font-weight: 800;
            color: #ffffff !important;
            letter-spacing: -0.5px;
        }

        .navbar-brand span {
            color: var(--accent);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 600;
            font-size: 0.85rem;
            margin: 0 5px;
            padding: 8px 18px !important;
            border-radius: 40px;
            transition: 0.2s;
        }

        .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.1);
        }

        /* CONTEÚDO */
        main {
            flex: 1; /* Garante que o conteúdo ocupe o espaço e empurre o footer */
            padding-bottom: 50px;
        }

        .card {
            border-radius: 35px !important;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 15px 45px var(--card-shadow);
            background: #ffffff;
            padding: 15px;
        }

        /* BOTÕES */
        .btn-primary, .btn-novo {
            background-color: var(--accent) !important;
            border-color: var(--accent) !important;
            color: #ffffff !important;
            border-radius: 50px !important;
            font-weight: 700;
            padding: 10px 28px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* FOOTER NO FINAL DA PÁGINA (CHÃO) */
        footer {
            background-color: var(--nav-bg);
            color: #ffffff;
            padding: 25px 0;
            text-align: center;
            font-weight: 500;
            font-size: 0.85rem;
            margin-top: auto;
            border-top: 4px solid var(--accent);
        }

        .theme-switch {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.3);
            color: #fff;
            border-radius: 50px;
            padding: 5px 15px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    @if (!Route::is('login') && !Route::is('cadastro'))
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">SCHEDULE<span>ONLINE</span></a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.index') }}">Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profissionais.index') }}">Profissionais</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('servicos.index') }}">Serviços</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('agendamentos.index') }}">Agendamentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Usuários</a></li>
                    </ul>
                    
                    <div class="d-flex align-items-center">
                        <button class="theme-switch me-3" onclick="toggleTheme()">Estilo</button>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm rounded-pill fw-bold px-3">Sair</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    @endif

    <main class="container">
        @yield('content')
    </main>

    <footer>
        &copy; 2026 Schedule Online - Gestão com Estilo
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleTheme() {
            const body = document.documentElement;
            const target = body.getAttribute('data-theme') === 'summer' ? 'default' : 'summer';
            body.setAttribute('data-theme', target);
            localStorage.setItem('theme', target);
        }

        if (localStorage.getItem('theme') === 'summer') {
            document.documentElement.setAttribute('data-theme', 'summer');
        }
    </script>
</body>
</html>