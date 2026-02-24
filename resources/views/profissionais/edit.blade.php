@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-primary">Editar Profissional: {{ $profissional->nome }}</h5>
                </div>
                
                <div class="card-body p-4">
                    {{-- SINTAXE: route('...', $profissional->id) --}}
                    {{-- SEMÂNTICA: Precisamos passar o ID para o servidor saber QUAL registro atualizar --}}
                    <form action="{{ route('profissionais.update', $profissional->id) }}" method="POST">
                        @csrf
                        {{-- 
                            SINTAXE: @method('PUT') 
                            SEMÂNTICA: Navegadores não suportam o verbo PUT nativamente em formulários. 
                            O Laravel usa este campo oculto para "fingir" um PUT para o Controller.
                        --}}
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nome Completo</label>
                                {{-- SINTAXE value="{{ old('nome', $profissional->nome) }}" --}}
                                {{-- SEMÂNTICA: Se houver erro, mostra o 'old'. Se não, mostra o valor que veio do banco --}}
                                <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                    value="{{ old('nome', $profissional->nome) }}" required>
                                @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">CPF</label>
                                <input type="text" name="CPF" class="form-control @error('CPF') is-invalid @enderror" 
                                    value="{{ old('CPF', $profissional->CPF) }}" required>
                                @error('CPF') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">E-mail</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email', $profissional->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold">Função / Especialidade</label>
                                <input type="text" name="funcao" class="form-control @error('funcao') is-invalid @enderror"
                                    value="{{ old('funcao', $profissional->funcao) }}" required>
                                @error('funcao') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('profissionais.index') }}" class="btn btn-light px-4">Voltar</a>
                            <button type="submit" class="btn btn-primary px-4">
                                Atualizar Dados
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
