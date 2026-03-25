<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Online | Premium</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --bg-body: #fdfdfd;
            --nav-bg: #121212;
            --accent: #007bff; 
            --text-main: #1a1a1a;
            --card-shadow: rgba(0, 0, 0, 0.08);
        }

        [data-theme="summer"] {
            --bg-body: #fffafa;
            --nav-bg: #432837;
            --accent: #ff758c; 
            --text-main: #2d1e26;
        }

        html, body { height: 100%; margin: 0; }
        body { display: flex; flex-direction: column; background-color: var(--bg-body); color: var(--text-main); font-family: 'Inter', sans-serif; transition: 0.3s; }

        .navbar-custom {
            background-color: var(--nav-bg) !important;
            margin: 20px auto;
            width: 95%;
            border-radius: 60px;
            padding: 10px 25px;
            box-shadow: 0 10px 30px var(--card-shadow);
        }

        .navbar-brand { font-weight: 800; color: #ffffff !important; }
        .navbar-brand span { color: var(--accent); }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 8px 18px !important;
            border-radius: 40px;
        }

        .nav-link:hover { color: #ffffff !important; background: rgba(255, 255, 255, 0.1); }

        /* COR DOS BOTÕES DOS FORMULÁRIOS */
        .btn-primary, .btn-submit, button[type="submit"]:not(.btn-light) {
            background-color: var(--accent) !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 50px !important;
            font-weight: 700 !important;
            padding: 12px 28px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        }

        main { flex: 1; padding: 20px 0; }

        footer {
            background-color: var(--nav-bg);
            color: #ffffff;
            padding: 15px 0;
            text-align: center;
            font-size: 0.8rem;
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
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">SCHEDULE<span>ONLINE</span></a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    {{-- MENU LIBERADO PARA TODOS LOGADOS --}}
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.index') }}">Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profissionais.index') }}">Profissionais</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('servicos.index') }}">Serviços</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('agendamentos.index') }}">Agendamentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Usuários</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('cobrancas.index') }}">Cobrança</a></li>
                    @endauth
                </ul>
                
                <div class="d-flex align-items-center">
                    <button class="theme-switch me-3" onclick="toggleTheme()">Estilo</button>
                    
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm rounded-pill fw-bold px-3">Sair</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm rounded-pill fw-bold px-3">Entrar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        &copy; 2026 Schedule Online - Gestão com Estilo
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // LÓGICA DO TEMA
        function toggleTheme() {
            const body = document.documentElement;
            const target = body.getAttribute('data-theme') === 'summer' ? 'default' : 'summer';
            body.setAttribute('data-theme', target);
            localStorage.setItem('theme', target);
        }
        if (localStorage.getItem('theme') === 'summer') {
            document.documentElement.setAttribute('data-theme', 'summer');
        }

        // LÓGICA VIACEP (Sempre Ativa)
        document.addEventListener('DOMContentLoaded', function() {
            const cepInput = document.getElementById('cep');
            if(cepInput) {
                cepInput.addEventListener('blur', function() {
                    let cep = this.value.replace(/\D/g, '');
                    if (cep.length === 8) {
                        // Preenche com "..." enquanto busca
                        document.getElementById('logradouro').value = "...";
                        document.getElementById('bairro').value = "...";
                        document.getElementById('cidade').value = "...";
                        document.getElementById('estado').value = "...";

                        fetch(`https://viacep.com.br/ws/${cep}/json/`)
                            .then(res => res.json())
                            .then(data => {
                                if (!data.erro) {
                                    document.getElementById('logradouro').value = data.logradouro;
                                    document.getElementById('bairro').value = data.bairro;
                                    document.getElementById('cidade').value = data.localidade;
                                    document.getElementById('estado').value = data.uf;
                                } else {
                                    alert("CEP não encontrado!");
                                }
                            })
                            .catch(() => alert("Erro ao buscar CEP."));
                    }
                });
            }
        });
    </script>
</body>
</html>