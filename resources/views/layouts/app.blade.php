<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Agenda | Gestão Inteligente</title>

    {{--
    SINTAXE: Link CSS externo.
    SEMÂNTICA: Importa o framework Bootstrap 5 para lidar com o design responsivo
    e componentes visuais sem precisar escrever CSS puro do zero.
    --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Importação de fonte moderna via Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Variáveis Globais de Cor */
        :root {
            --bs-primary: #4f46e5; /* Azul indigo moderno */
            --bs-body-bg: #f8fafc; /* Fundo cinza super suave */
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bs-body-bg);
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Mantém o rodapé no fundo mesmo com pouco conteúdo */
        }

        .main-content {
            flex: 1; /* Faz esta área esticar para preencher o espaço vazio */
        }

        /* Customização da Navbar */
        .navbar {
            background-color: var(--bs-primary) !important;
            padding: 0.8rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
        }

        /* Estilos Globais para os "Filhos" (Cards, Tabelas, Inputs) */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .table thead th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #64748b;
            border-top: none;
        }

        .badge {
            padding: 0.5em 1em;
            font-weight: 600;
            border-radius: 30px;
        }

        .form-control, .form-select {
            border-color: #e2e8f0;
            padding: 0.6rem 0.8rem;
            border-radius: 8px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
    </style>
</head>

<body class="bg-light">

    {{-- Script de Autocompletar CEP --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cepField = document.getElementById('cep');

            if (cepField) { // Verifica se o campo existe na página atual
                cepField.addEventListener('blur', function () {
                    let cep = this.value.replace(/\D/g, '');

                    if (cep.length === 8) {
                        // Semântica: Faz a requisição para a API externa
                        fetch(`https://viacep.com.br/ws/${cep}/json/`)
                            .then(res => res.json())
                            .then(dados => {
                                if (!dados.erro) {
                                    // Sintaxe: Preenche os IDs
                                    if(document.getElementById('bairro')) document.getElementById('bairro').value = dados.bairro;
                                    if(document.getElementById('cidade')) document.getElementById('cidade').value = dados.localidade;
                                    if(document.getElementById('estado')) document.getElementById('estado').value = dados.uf;
                                    if(document.getElementById('logradouro')) document.getElementById('logradouro').value = dados.logradouro;
                                }
                            });
                    }
                });
            }
        });
    </script>

    {{-- Barra de Navegação Superior --}}
    @if (!Route::is('login') && !Route::is('cadastro'))
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
            <div class="container">
                {{-- Link para a raiz do site --}}
                <a class="navbar-brand" href="/">
                    Sistema de Agenda
                </a>

                {{-- Botão "Hambúrguer" para dispositivos móveis --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item"><a class="nav-link" href="{{ route('profissionais.index') }}">Profissionais</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('servicos.index') }}">Serviços</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('agendamentos.index') }}">Agendamentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Usuários</a></li>
                        
                        <li class="nav-item ms-lg-4 mt-2 mt-lg-0">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-light btn-sm fw-bold px-3 py-2 rounded-3">
                                    Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endif

    {{-- 
    ÁREA DE CONTEÚDO DINÂMICO
    Corrigido para não usar min-vh-100 junto com justify-content-center, 
    o que quebrava o layout caso a tabela ficasse muito grande.
    --}}
    <main class="main-content py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Rodapé Estático --}}
    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center text-muted">
            <small>&copy; {{ date('Y') }} Sistema de Agenda - Todos os direitos reservados.</small>
        </div>
    </footer>

    {{--
    SCRIPTS JS
    SINTAXE: <script src="...">
    SEMÂNTICA: Carrega a lógica do Bootstrap (como o funcionamento do menu mobile). 
    Fica no final para não travar o carregamento visual da página (Performance).
    --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>