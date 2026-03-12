{{--
SINTAXE: @extends('layouts.app')
SEMÂNTICA: Herança de template. Informa que esta view vai "preencher" as lacunas
do arquivo base (app.blade.php), mantendo o cabeçalho e rodapé padrão.
--}}
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
                    {{--
                    SINTAXE: <form action="{{ route('...') }}" method="POST">
                    SEMÂNTICA: Define o destino dos dados. O método POST é obrigatório para
                    segurança em operações de escrita (criação) no banco de dados.
                    --}}
                    <form action="{{ route('servicos.store') }}" method="POST">
                        {{--
                        SINTAXE: @csrf
                        SEMÂNTICA: Cross-Site Request Forgery. É um token de segurança obrigatório
                        do Laravel. Sem ele, o servidor rejeita o formulário (Erro 419).
                        --}}
                        @csrf

                        <div class="row">
                            {{-- Campo: Nome --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nome Serviço</label>
                                {{--
                                SINTAXE: name="nome" | value="{{ old('nome') }}"
                                SEMÂNTICA:
                                - 'name': Chave que o Controller usará ($request->nome).
                                - 'old()': Se houver erro de validação, mantém o que o usuário já digitou.
                                - '@error': Verifica se o servidor retornou erro para este campo específico.
                                --}}
                                <input type="text" name="nome"
                                    class="form-control @error('nome') is-invalid @enderror"
                                    value="{{ old('nome') }}" required placeholder="Ex: Corte de Cabelo">

                                {{-- Exibe a mensagem de erro vinda do Controller --}}
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Campo: Descrição (ADICIONADO AQUI) --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Descrição do Serviço</label>
                                <textarea name="descricao" rows="3"
                                    class="form-control @error('descricao') is-invalid @enderror"
                                    required placeholder="Ex: Corte de cabelo masculino completo com lavagem...">{{ old('descricao') }}</textarea>
                                
                                @error('descricao')
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
                                        value="{{ old('preco') }}" required placeholder="0.00">
                                </div>
                                @error('preco')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Campo: Duração --}}
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
                            
                            {{-- Campo: Status --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Status do Serviço</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror"
                                    required>
                                    <option value="">Selecione um status...</option>
                                    <option value="Ativo" {{ old('status') == 'Ativo' ? 'selected' : '' }}>Ativo
                                    </option>
                                    <option value="Inativo" {{ old('status') == 'Inativo' ? 'selected' : '' }}>Inativo
                                    </option>
                                </select>

                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                {{-- Botão Voltar: Apenas um link estilizado --}}
                                <a href="{{ route('servicos.index') }}" class="btn btn-light px-4">Cancelar</a>

                                {{--
                                SINTAXE: type="submit"
                                SEMÂNTICA: Gatilho que dispara o evento de envio do formulário.
                                --}}
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