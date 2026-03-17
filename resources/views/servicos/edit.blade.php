@extends('layouts.app')

@section('content')
<style>
     @keyframes gradientAnimation {
        0% { background-position: 20% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 20% 50%; }
    }
    /* Fundo degradê idêntico ao das outras telas */
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
        color: var(--text-primary) !important;
        transition: color 0.5s ease;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3) !important;
        backdrop-filter: blur(5px);
    }

    .form-label {
        color: var(--text-primary) !important; /* Puxa a cor do tema atual */
        transition: color 0.5s ease;
        font-weight: 700;
    }

    .input-group-text {
        background-color: #f8f9fa;
        color: var(--text-primary) !important; /* Puxa a cor do tema atual */
        transition: color 0.5s ease;
        border-right: none;
    }

    /* Botão Atualizar: Azul conforme seu padrão */
    .btn-update-custom {
       background: var(--bg-gradient) !important;
        background-size: 400% 400% !important;
        animation: gradientAnimation 10s ease infinite !important;
        border: none !important;
        color: white !important;
        font-weight: bold !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-update-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        color: white !important;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card custom-card-form">
                <div class="card-header bg-transparent border-0 pt-4 px-4 text-center">
                    <h4 class="mb-0 fw-bold" style="color: #3A0256;">Editar Serviço: {{ $servico->nome }}</h4>
                </div>

                <div class="card-body p-4">
                    {{-- Mantida a rota original --}}
                    <form action="{{ route('servicos.update', $servico->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Nome do Serviço --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nome do Serviço</label>
                                <input type="text" name="nome" 
                                    class="form-control @error('nome') is-invalid @enderror"
                                    value="{{ old('nome', $servico->nome) }}" required>
                                @error('nome') 
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div> 
                                @enderror
                            </div>

                            {{-- Descrição --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Descrição do Serviço</label>
                                <textarea name="descricao" rows="3"
                                    class="form-control @error('descricao') is-invalid @enderror"
                                    required>{{ old('descricao', $servico->descricao) }}</textarea>
                                @error('descricao')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Preço --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Preço do Serviço</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="preco" step="0.01" min="0"
                                        class="form-control @error('preco') is-invalid @enderror"
                                        value="{{ old('preco', $servico->preco) }}" required>
                                </div>
                                @error('preco')
                                    <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Duração --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duração (minutos)</label>
                                <div class="input-group">
                                    <input type="number" name="duracao"
                                        class="form-control @error('duracao') is-invalid @enderror"
                                        value="{{ old('duracao', $servico->duracao) }}" 
                                        placeholder="Ex: 60" required min="1">
                                    <span class="input-group-text">min</span>
                                </div>
                                @error('duracao') 
                                    <div class="invalid-feedback d-block fw-bold">{{ $message }}</div> 
                                @enderror
                            </div>
                            
                            {{-- Status --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Status do Serviço</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="Ativo" {{ old('status', $servico->status) == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                    <option value="Inativo" {{ old('status', $servico->status) == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('servicos.index') }}" class="btn btn-light px-4 fw-bold text-secondary text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-update-custom">
                                <i class="fas fa-save me-1"></i> Atualizar Dados
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection