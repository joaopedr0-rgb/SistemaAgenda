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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Mantém o rodapé no fundo mesmo com pouco conteúdo */
        }

        .main-content {
            flex: 1;
        }

        /* Faz esta área "esticar" para preencher o espaço vazio */
        .navbar-brand {
            font-weight: 600;
            letter-spacing: -0.5px;
        }
    </style>
</head>

<body class="bg-light">

    {{-- Barra de Navegação Superior --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-5">
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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('profissionais.index') }}">Profissionais</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('clientes.index') }}">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('servicos.index') }}">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('agendamentos.index') }}">Agendamentos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('recepcionista.index') }}">Recepcionistas</a></li>
                    <li class="nav-item ms-lg-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm">
                                Sair
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{--
    ÁREA DE CONTEÚDO DINÂMICO
    SINTAXE: @yield('nome_da_secao')
    SEMÂNTICA: Este é um "espaço reservado". O Laravel ficará esperando que um
    arquivo "filho" use @section('content') para injetar o HTML aqui dentro.
    É o que permite que a barra de navegação e o footer sejam os mesmos em todas as páginas.
    --}}
    <main class="container main-content">
        @yield('content')
    </main>

    {{-- Rodapé Estático --}}
    <footer class="bg-white border-top py-4 mt-5">
        <div class="container text-center text-muted">
            <small>&copy; 2026 Sistema de Agenda - Todos os direitos reservados.</small>
        </div>
    </footer>

    {{--
    SCRIPTS JS
    SINTAXE:
    <script src="...">
        SEMÂNTICA: Carrega a lógica do Bootstrap(como o funcionamento do menu mobile). 
        Fica no final para não travar o carregamento visual da página(Performance).
    --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>