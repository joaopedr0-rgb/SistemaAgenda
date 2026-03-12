@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-primary">Cadastrar Novo Servico</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('servicos.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nome Serviço</label>
                                <input type="text" name="nome"
                                    class="form-control @error('nome') is-invalid @enderror"
                                    value="{{ old('nome') }}" required placeholder="Ex: Corte de Cabelo">

                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Descrição do Serviço</label>
                                <textarea name="descricao" rows="3"
                                    class="form-control @error('descricao') is-invalid @enderror"
                                    required placeholder="Ex: Corte de cabelo masculino completo com lavagem...">{{ old('descricao') }}</textarea>
                                
                                @error('descricao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Preço do Serviço</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="preco" step="0.01" min="0"
                                        class="form-control @error('preco') is-invalid @enderror"
                                        value="{{ old('preco') }}" required placeholder="0.00">
                                </div>
                                @error('preco')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Duração do Serviço</label>
                                <div class="input-group">
                                    <input type="number" name="duracao"
                                        class="form-control @error('duracao') is-invalid @enderror"
                                        value="{{ old('duracao') }}" placeholder="Ex: 60" required min="1">
                                    <span class="input-group-text">minutos</span>
                                </div>
                                @error('duracao')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Status do Serviço</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">Selecione um status...</option>
                                    <option value="Ativo" {{ old('status') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                    <option value="Inativo" {{ old('status') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                                </select>

                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{ route('servicos.index') }}" class="btn btn-light px-4">Cancelar</a>

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-lg"></i> Salvar Serviço
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection