@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-primary">Editar Serviço: {{ $servico->nome }}</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('servicos.update', $servico->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Campo: Nome --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nome do Serviço</label>
                                <input type="text" name="nome" 
                                    class="form-control @error('nome') is-invalid @enderror"
                                    value="{{ old('nome', $servico->nome) }}" required>
                                @error('nome') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            {{-- Campo: Preço --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Preço do Serviço</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="preco" step="0.01" min="0"
                                        class="form-control @error('preco') is-invalid @enderror"
                                        value="{{ old('preco', $servico->preco) }}" required>
                                </div>
                                @error('preco')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Campo: Duração --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Duração (minutos)</label>
                                <div class="input-group">
                                    <input type="number" name="duracao"
                                        class="form-control @error('duracao') is-invalid @enderror"
                                        value="{{ old('duracao', $servico->duracao) }}" 
                                        placeholder="Ex: 60" required min="1">
                                    <span class="input-group-text">min</span>
                                </div>
                                @error('duracao') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('servicos.index') }}" class="btn btn-light px-4">Voltar</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg"></i> Atualizar Dados
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection