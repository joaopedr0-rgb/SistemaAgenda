{{--
SINTAXE: @extends('layouts.app')
SEMÂNTICA: Herança de template. Informa que esta view vai "preencher" as lacunas
do arquivo base (app.blade.php), mantendo o cabeçalho e rodapé padrão.
--}}
@extends('layouts.app')

@section('content')
    <style>
        @keyframes gradientAnimation {
            0% {
                background-position: 20% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Fundo padrão do sistema com o degradê moderno */
        body {
            background: var(--bg-gradient) !important;
            background-size: 400% 400% !important;
            animation: gradientAnimation 15s ease infinite !important;
            background-attachment: fixed !important;
            min-height: 100vh;
            transition: background 0.5s ease;
        }

        .custom-card-form {
            border: none !important;
            border-radius: 20px !important;
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3) !important;
            backdrop-filter: blur(5px);
        }

        .card-header-custom {
            background: transparent !important;
            border-bottom: 1px solid #eee !important;
            padding: 25px !important;
        }

        .card-header-custom h4 {
            background: #f8f9fa !important;
            color: var(--text-primary) !important;
            font-weight: 800 !important;
            margin: 0;
            border: 1px solid #ddd !important;
            padding: 12px 30px !important;
            border-radius: 12px !important;
            transition: all 0.3s;
        }

        /* Estilização dos Rótulos e Inputs */
        .form-label {
            color: var(--text-primary) !important;
            transition: color 0.5s ease;
            font-weight: 700 !important;
            font-size: 0.9rem;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px !important;
            border: 2px solid #f0f0f0 !important;
            padding: 12px !important;
            transition: all 0.3s ease;
        }

        .form-select,
        .input-group-text {
            border-radius: 12px !important;
            border: 2px solid #f0f0f0 !important;
            padding: 12px !important;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--bg-gradient) !important;
            box-shadow: 0 0 0 0.25rem rgba(216, 27, 96, 0.1) !important;
        }

        /* Botões */
        .btn-save-custom {
            background: var(--bg-gradient) !important;
            background-size: 400% 400% !important;
            animation: gradientAnimation 10s ease infinite !important;
            border: none !important;
            color: white !important;
            font-weight: bold !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-save-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            color: white !important;
        }

        .btn-cancel-custom {
            background: #f8f9fa !important;
            color: #666 !important;
            font-weight: 700 !important;
            border: 1px solid #ddd !important;
            padding: 12px 30px !important;
            border-radius: 12px !important;
            transition: all 0.3s;
        }

        .btn-cancel-custom:hover {
            background: #eee !important;
        }

        /* Ajuste para input groups com bordas arredondadas */
        .input-group>.form-control {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .input-group>.input-group-text:last-child {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
            background-color: #f8f9fa;
            color: var(--text-primary) !important;
            font-weight: 600;
        }

        .input-group>.input-group-text:first-child {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            background-color: #f8f9fa;
            color: var(--text-primary) !important;
            font-weight: 600;
        }

        .input-group>.form-control:not(:first-child) {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card custom-card-form">

                    <div class="card-header-custom text-center">
                        <h4><i class="fas fa-concierge-bell me-2"></i>Cadastrar Novo Serviço</h4>
                    </div>

                    <div class="card-body p-4">
                        {{-- FUNCIONALIDADE MANTIDA: Rota original para salvar serviço --}}
                        <form action="{{ route('servicos.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                {{-- Campo: Nome --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Nome Serviço</label>
                                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                        value="{{ old('nome') }}" required placeholder="Ex: Corte de Cabelo">
                                    @error('nome')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Campo: Descrição --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Descrição do Serviço</label>
                                    <textarea name="descricao" rows="3"
                                        class="form-control @error('descricao') is-invalid @enderror" required
                                        placeholder="Ex: Corte de cabelo masculino completo com lavagem...">{{ old('descricao') }}</textarea>
                                    @error('descricao')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Campo: Preço --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Preço do Serviço</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" name="preco" step="0.01" min="0"
                                            class="form-control @error('preco') is-invalid @enderror"
                                            value="{{ old('preco') }}" required placeholder="0.00">
                                    </div>
                                    @error('preco')
                                        <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Campo: Duração --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Duração do Serviço</label>
                                    <div class="input-group">
                                        <input type="number" name="duracao"
                                            class="form-control @error('duracao') is-invalid @enderror"
                                            value="{{ old('duracao') }}" placeholder="Ex: 60" required min="1">
                                        <span class="input-group-text">minutos</span>
                                    </div>
                                    @error('duracao')
                                        <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Campo: Status --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Status do Serviço</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror"
                                        required>
                                        <option value="">Selecione um status...</option>
                                        <option value="Ativo" {{ old('status') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                        <option value="Inativo" {{ old('status') == 'Inativo' ? 'selected' : '' }}>Inativo
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="text-light my-4">

                            <div class="d-flex justify-content-between mt-3">
                                {{-- Link para voltar à listagem --}}
                                <a href="{{ route('servicos.index') }}" class="btn btn-cancel-custom text-decoration-none">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </a>

                                <button type="submit" class="btn btn-save-custom">
                                    <i class="fas fa-check-circle me-1"></i> Salvar Serviço
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection