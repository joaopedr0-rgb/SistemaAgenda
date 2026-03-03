@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Editar Cliente: {{ $cliente->nome }}</h5>
    </div>

    <div class="card-body">
        {{-- 
            SINTAXE: route('clientes.update', $cliente->id)
            SEMÂNTICA: Aponta para o método update do Controller, passando o ID do registro.
        --}}
        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            {{-- 
                SINTAXE: @method('PUT')
                SEMÂNTICA: O HTML só suporta GET/POST. O Laravel usa isso para simular o método PUT/PATCH 
                exigido para atualizações parciais ou totais de recursos.
            --}}
            @method('PUT')

            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
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
                <a href="{{ route('clientes.index') }}" class="btn btn-light border">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

@endsection