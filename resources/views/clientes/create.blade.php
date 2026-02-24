@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">Novo Cliente</h5>
            </div>
            <div class="card-body p-4">
                {{-- 
                    SINTAXE: action="{{ route('clientes.store') }}" 
                    SEMÂNTICA: Aponta para o método 'store' do Controller. 
                    O formulário envia os dados via POST, que é o padrão para criação de recursos.
                --}}
                <form action="{{ route('clientes.store') }}" method="POST">
                    
                    {{-- 
                        SINTAXE: @csrf 
                        SEMÂNTICA: Obrigatório! Cria um campo oculto com um token de segurança. 
                        Sem isso, o Laravel retorna erro "419 Page Expired" por proteção contra ataques.
                    --}}
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Nome Completo</label>
                            {{-- 
                                SINTAXE: @error('nome') is-invalid @enderror 
                                SEMÂNTICA: Se a validação no Controller falhar para o campo 'nome', 
                                o Laravel adiciona a classe CSS do Bootstrap que deixa a borda vermelha.

                                SINTAXE: value="{{ old('nome') }}"
                                SEMÂNTICA: Função de persistência. Se o formulário der erro em outro campo, 
                                o que o usuário já digitou aqui não é apagado (melhora a experiência do usuário).
                            --}}
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
                            
                            {{-- 
                                SINTAXE: @error('nome') ... @enderror
                                SEMÂNTICA: Exibe a mensagem de erro específica vinda do Controller (ex: "O campo nome é obrigatório").
                            --}}
                            @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">E-mail</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telefone</label>
                            {{-- Aqui não há @error, pois no seu Controller o telefone é 'nullable' (opcional) --}}
                            <input type="text" name="telefone" class="form-control" value="{{ old('telefone') }}" placeholder="(00) 00000-0000">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        {{-- Botão de cancelar apenas redireciona para a lista sem salvar nada --}}
                        <a href="{{ route('clientes.index') }}" class="btn btn-light border">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4">Salvar Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection