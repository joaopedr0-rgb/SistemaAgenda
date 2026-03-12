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
                    O formulário envia os dados via POST, que é o padrão para criação de recursos no padrão REST.
                --}}
                <form action="{{ route('clientes.store') }}" method="POST">
                    
                    {{-- 
                        SINTAXE: @csrf 
                        SEMÂNTICA: Cross-Site Request Forgery. Obrigatório! Cria um token de segurança único para a sessão. 
                        O Laravel usa isso para garantir que foi VOCÊ (do seu site) que enviou o formulário, e não um site hacker.
                    --}}
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Nome Completo</label>
                            {{-- 
                                SINTAXE: @error('nome') is-invalid @enderror 
                                SEMÂNTICA: Validação Visual. Se o Controller encontrar um erro no campo 'nome', 
                                ele "pinga" de volta para a View e o Blade injeta a classe 'is-invalid' do Bootstrap.

                                SINTAXE: value="{{ old('nome') }}"
                                SEMÂNTICA: Persistência de Dados (UX). Se o e-mail estiver errado, o usuário não 
                                perde o nome que já digitou. O Laravel "lembra" do valor da tentativa anterior.
                            --}}
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
                            
                            {{-- 
                                SINTAXE: @error('nome') ... @enderror
                                SEMÂNTICA: Exibe a mensagem de erro amigável definida no Controller ou no arquivo de tradução do Laravel.
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
                            {{-- 
                                SINTAXE: input type="text" 
                                SEMÂNTICA: Como no seu Controller o telefone provavelmente é 'nullable' (opcional), 
                                não há diretiva de erro aqui, permitindo que o usuário deixe em branco se desejar.
                            --}}
                            <input type="text" name="telefone" class="form-control" value="{{ old('telefone') }}" placeholder="(00) 00000-0000">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        {{-- 
                            SINTAXE: a href="{{ route('clientes.index') }}"
                            SEMÂNTICA: Link de escape. Redireciona o usuário de volta para a lista, 
                            cancelando a operação de cadastro sem processar nada no servidor.
                        --}}
                        <a href="{{ route('clientes.index') }}" class="btn btn-light border">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4">Salvar Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection