@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        {{-- SINTAXE: $cliente->nome --}}
        {{-- SEMÂNTICA: Exibe o nome atual do cliente no título para que o usuário saiba exatamente quem está editando. --}}
        <h5 class="mb-0 fw-bold">Editar Cliente: {{ $cliente->nome }}</h5>
    </div>

    <div class="card-body">
        {{-- 
            SINTAXE: route('clientes.update', $cliente->id)
            SEMÂNTICA: Gera a URL de destino (ex: /clientes/5). 
            Diferente do 'store', aqui precisamos passar o ID para o Controller saber QUAL registro alterar no banco.
        --}}
        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            {{-- 
                SINTAXE: @method('PUT')
                SEMÂNTICA: Falsificação de Método (Method Spoofing). 
                Navegadores só entendem GET e POST. O Laravel intercepta esse POST e, graças a essa diretiva, 
                o redireciona para a função 'update' do seu Controller, respeitando o padrão RESTful.
            --}}
            @method('PUT')

            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                {{-- 
                    SINTAXE: value="{{ old('nome', $cliente->nome) }}"
                    SEMÂNTICA: Lógica de Preenchimento Automático.
                    1. Se o usuário tentou salvar e deu erro, o 'old' recupera o que ele digitou.
                    2. Se é a primeira vez que ele abre a página, o 'old' vem vazio e o Laravel usa o segundo 
                       parâmetro ($cliente->nome), que é o dado atual vindo do banco de dados.
                --}}
                <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $cliente->nome) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $cliente->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" value="{{ old('telefone', $cliente->telefone) }}">
            </div>

            <div class="d-flex justify-content-between">
                {{-- SINTAXE: route('clientes.index') --}}
                {{-- SEMÂNTICA: Botão de pânico/desistir. Leva o usuário de volta para a listagem sem alterar nada. --}}
                <a href="{{ route('clientes.index') }}" class="btn btn-light border">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

@endsection