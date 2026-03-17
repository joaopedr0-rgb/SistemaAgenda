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
        /* =========================================================
       1. DEFINIÇÃO DAS VARIÁVEIS DE COR (O SEGREDO DO TEMA)
       ========================================================= */
        :root {
            /* Fundo Dinâmico (Body e Navbar) */
            --bg-gradient: linear-gradient(-45deg, #3A0256, #d81b60, #6a1b9a, #ad1457);

            /* Títulos e Labels */
            --text-primary: #3A0256;

            /* BOTÃO EDITAR: Branco com contorno roxo (padrão) */
            --btn-edit-bg: #ffffff;
            --btn-edit-text: #3A0256;
            --btn-edit-border: #3A0256;

            /* BOTÃO EXCLUIR: Padrão perigoso (vermelho) */
            --btn-delete-bg: #dc3545;
            --btn-delete-text: #ffffff;
        }

        [data-theme="summer"] {
            /* Fundo Dinâmico (Verão - Azul/Verde) */
            --bg-gradient: linear-gradient(-45deg, #334086, #3770c5, #335c92, #28b485);

            /* Títulos e Labels (Azul Escuro) */
            --text-primary: #005f73;

            /* BOTÃO EDITAR: Agora fica verde/azul para combinar */
            --btn-edit-bg: #ffffff;
            --btn-edit-text: #28b485;
            --btn-edit-border: #28b485;

            /* BOTÃO EXCLUIR: Mantemos o vermelho por segurança */
            --btn-delete-bg: #dc3545;
            --btn-delete-text: #ffffff;
        }

        /* Animação do Gradiente */
        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }


        /* =========================================================
       2. APLICAÇÃO DOS ESTILOS DINÂMICOS (UNIFICADO)
       ========================================================= */
      

        body {
            background: var(--bg-gradient) !important;
            background-size: 400% 400% !important;
            animation: gradientAnimation 15s ease infinite !important;
            background-attachment: fixed !important;
            min-height: 100vh;
            transition: background 0.5s ease;
        }

        .navbar-custom {
            background: var(--bg-gradient) !important;
            background-size: 400% 400% !important;
            animation: gradientAnimation 10s ease infinite !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border: none !important;
            transition: background 0.5s ease;
        }

        /* Títulos e Labels dinâmicos */
        .form-label,
        .fw-bold,
        h4,
        h5,
        .card-header-title {
            color: var(--text-primary) !important;
            transition: color 0.5s ease;
        }


        /* =========================================================
       3. BOTÕES DE AÇÃO NA TABELA (DINÂMICOS)
       ========================================================= */

        /* Botão Editar: Puxa as variáveis '--btn-edit' */
        .btn-edit-custom {
            background: var(--bg-gradient) !important;
            background-size: 400% 400% !important;
            animation: gradientAnimation 10s ease infinite !important;
            border: none !important;
            color: white !important;
            font-weight: 600 !important;
            transition: all 0.3s ease;
        }

        /* Efeito de destaque ao passar o mouse */
        .btn-update-custom:hover,
        .btn-edit-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            color: white !important;
        }

        /* Manter o Excluir Vermelho para segurança (Opcional: pode colocar degradê tmb) */

        /* =========================================================
       4. ESTILOS DE BRANDING E LINKS (MANTIDOS)
       ========================================================= */

        .brand-first-word {
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .brand-second-word {
            background: #ffffff;
            color: var(--text-primary);
            /* Dinâmico */
            padding: 2px 8px;
            border-radius: 6px;
            margin-left: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: color 0.5s ease;
        }

        .navbar-brand {
            font-weight: 800 !important;
            letter-spacing: 1px;
        }

        .nav-link {
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff !important;
        }

        .btn-sair-custom {
            font-weight: bold !important;
            border-radius: 8px !important;
            transition: transform 0.2s;
        }
    </style>
</head>


<body class="bg-light">

    <script>
        /*SINTAXE: document.addEventListener('DOMContentLoaded', ...)
   SEMÂNTICA: Garante que o script só rode quando todo o HTML da página for carregado,
   evitando erros ao tentar buscar campos que ainda não existem no navegador.
*/
        document.addEventListener('DOMContentLoaded', function () {
            const cepField = document.getElementById('cep');
            /* SINTAXE: document.getElementById('cep')
                   SEMÂNTICA: Cria uma "ponte" entre o JavaScript e o seu campo de input do CEP. 
                   Ele procura no seu formulário o elemento que possui id="cep".
                */
            if (cepField) { // Verifica se o campo existe na página atual
                /* SINTAXE: if (cepField) { ... }
                SEMÂNTICA: Verifica se o campo existe na página atual. Isso evita que o código 
                 tente rodar na tela de Login, onde o campo CEP não existe.
                */
                cepField.addEventListener('blur', function () {
                    let cep = this.value.replace(/\D/g, '');
                    /* SINTAXE: .replace(/\D/g, '')
                            SEMÂNTICA: Limpa o que foi digitado, removendo traços e pontos. 
                            Garante que fiquem apenas os 8 números exigidos pela API ViaCEP.
                         */

                    if (cep.length === 8) {
                        /* SINTAXE: if (cep.length === 8) { ... }
                   SEMÂNTICA: Só faz a requisição se o CEP estiver completo. 
                   Evita disparar chamadas desnecessárias para a internet com CEPs incompletos.
                */

                        fetch(`https://viacep.com.br/ws/${cep}/json/`)
                            .then(res => res.json())
                            .then(dados => {
                                if (!dados.erro) {
                                    // Sintaxe: Preenche os IDs que conferimos no seu código
                                    document.getElementById('bairro').value = dados.bairro;
                                    document.getElementById('cidade').value = dados.localidade;
                                    document.getElementById('estado').value = dados.uf;
                                    // Adicione o campo de logradouro se você o criou
                                    if (document.getElementById('logradouro')) {
                                        document.getElementById('logradouro').value = dados.logradouro;
                                    }
                                }
                            });
                    }
                });
            }
        });
    </script>

    {{-- Barra de Navegação Superior --}}
    @if (!Route::is('login') && !Route::is('cadastro'))
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-5">
            <div class="container">
                {{-- Link para a raiz do site --}}
                <a class="navbar-brand navbar-brand-custom" href="/">
                    <span class="brand-first-word">SCHEDULE</span>
                    <span class="brand-second-word">ONLINE</span>
                </a>

                {{-- Botão "Hambúrguer" para dispositivos móveis --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('dashboard.index') }}">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('profissionais.index') }}">Profissionais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('clientes.index') }}">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('servicos.index') }}">Serviços</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('agendamentos.index') }}">Agendamentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('usuarios.index') }}">Usuários</a>
                        </li>
                        <li class="nav-item d-flex align-items-center me-2">
                            <button id="theme-toggler" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                <i class="fas fa-palette me-1"></i> Trocar Tema
                            </button>
                        </li>

                        <li class="nav-item ms-lg-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-light btn-sm btn-sair-custom">
                                    Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endif
    <main class="py-5 min-vh-100 d-flex flex-column justify-content-center">
        <div class="container">
            @yield('content')
        </div>
    </main>
    {{--
    ÁREA DE CONTEÚDO DINÂMICO
    SINTAXE: @yield('nome_da_secao')
    SEMÂNTICA: Este é um "espaço reservado". O Laravel ficará esperando que um
    arquivo "filho" use @section('content') para injetar o HTML aqui dentro.
    É o que permite que a barra de navegação e o footer sejam os mesmos em todas as páginas.
    --}}
    {{--<main class="container main-content">
        @yield('content')
    </main>--}}

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
        <script>
            const themeToggler = document.getElementById('theme-toggler');
            const body = document.documentElement; // Pega o <html> para aplicar o atributo

                // Verifica se já existe um tema salvo
                const currentTheme = localStorage.getItem('theme') || 'default';
                if (currentTheme === 'summer') {
                    body.setAttribute('data-theme', 'summer');
    }

    themeToggler.addEventListener('click', () => {
        if (body.getAttribute('data-theme') === 'summer') {
                    body.removeAttribute('data-theme');
                localStorage.setItem('theme', 'default');
        } else {
                    body.setAttribute('data-theme', 'summer');
                localStorage.setItem('theme', 'summer');
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>