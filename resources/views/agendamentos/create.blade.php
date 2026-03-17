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
                background-position: 20% 50%;
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
            color: var(--text-primary) !important;
        transition: color 0.5s ease;
            backdrop-filter: blur(5px);
        }

        .card-header-custom {
              background: transparent !important;
        border-bottom: 1px solid #eee !important;
        
            background: transparent !important;
            border-bottom: 1px solid #eee !important;
            padding: 25px !important;
        }

        .card-header-custom h4 {
            color: var(--text-primary) !important;
            font-weight: 800 !important;
            margin: 0;
        }

        /* Estilização dos Rótulos e Inputs */
        .form-label {
            color: var(--text-primary) !important;
            font-weight: 700 !important;
            font-size: 0.9rem;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 12px !important;
            border: 2px solid #f0f0f0 !important;
            padding: 12px !important;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--text-primary) !important;
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
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
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
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card custom-card-form">

                    <div class="card-header-custom text-center">
                        <h4><i class="fas fa-calendar-alt me-2"></i>Realizar Agendamento</h4>
                    </div>

                    <div class="card-body p-4">
                        {{-- FUNCIONALIDADE MANTIDA: Rota original agendamentos.store --}}
                        <form action="{{ route('agendamentos.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                {{-- Seleção de Cliente --}}
                                <div class="col-md-12 mb-3">
                                    <label for="cliente_id" class="form-label">Cliente</label>
                                    <select name="cliente_id" id="cliente_id"
                                        class="form-select @error('cliente_id') is-invalid @enderror" required>
                                        <option value="">Selecione o Cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Seleção de Profissional --}}
                                <div class="col-md-12 mb-3">
                                    <label for="profissional_id" class="form-label">Profissional</label>
                                    <select name="profissional_id" id="profissional_id"
                                        class="form-select @error('profissional_id') is-invalid @enderror" required>
                                        <option value="">Selecione o Profissional</option>
                                        @foreach($profissionais as $profissional)
                                            <option value="{{ $profissional->id }}" {{ old('profissional_id') == $profissional->id ? 'selected' : '' }}>
                                                {{ $profissional->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('profissional_id')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Seleção de Serviço --}}
                                <div class="col-md-12 mb-3">
                                    <label for="servico_id" class="form-label">Serviço</label>
                                    <select name="servico_id" id="servico_id"
                                        class="form-select @error('servico_id') is-invalid @enderror" required>
                                        <option value="">Selecione o Serviço</option>
                                        @foreach($servicos as $servico)
                                            <option value="{{ $servico->id }}" {{ old('servico_id') == $servico->id ? 'selected' : '' }}>
                                                {{ $servico->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('servico_id')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Data do Agendamento --}}
                                <div class="col-md-6 mb-3">
                                    <label for="data" class="form-label">Data</label>
                                    <input type="date" name="data" id="data"
                                        class="form-control @error('data') is-invalid @enderror" value="{{ old('data') }}"
                                        required>
                                    @error('data')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Hora do Agendamento --}}
                                <div class="col-md-6 mb-3">
                                    <label for="hora" class="form-label">Hora</label>
                                    <input type="time" name="hora" id="hora"
                                        class="form-control @error('hora') is-invalid @enderror" value="{{ old('hora') }}"
                                        required>
                                    @error('hora')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="text-light my-4">

                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('agendamentos.index') }}"
                                    class="btn btn-cancel-custom text-decoration-none">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </a>

                                <button type="submit" class="btn btn-save-custom">
                                    <i class="fas fa-check-circle me-1"></i> Salvar Agendamento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection