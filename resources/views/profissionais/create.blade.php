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
                    <h5 class="mb-0 fw-bold text-primary">Cadastrar Novo Profissional</h5>
                </div>
                
                <div class="card-body p-4">
                    {{-- 
                        SINTAXE: <form action="{{ route('...') }}" method="POST"> 
                        SEMÂNTICA: Define o destino dos dados. O método POST é obrigatório para 
                        segurança em operações de escrita (criação) no banco de dados.
                    --}}
                    <form action="{{ route('profissionais.store') }}" method="POST">
                        
                        {{-- 
                            SINTAXE: @csrf 
                            SEMÂNTICA: Cross-Site Request Forgery. É um token de segurança obrigatório 
                            do Laravel. Sem ele, o servidor rejeita o formulário (Erro 419).
                        --}}
                        @csrf

                        <div class="row">
                            
                            {{-- Campo: Nome --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nome Completo</label>
                                {{-- 
                                    SINTAXE: name="nome" | value="{{ old('nome') }}" 
                                    SEMÂNTICA: 
                                    - 'name': Chave que o Controller usará ($request->nome).
                                    - 'old()': Se houver erro de validação, mantém o que o usuário já digitou.
                                    - '@error': Verifica se o servidor retornou erro para este campo específico.
                                --}}
                                <input type="text" name="nome" 
                                    class="form-control @error('nome') is-invalid @enderror"
                                    value="{{ old('nome') }}" required placeholder="Ex: João Silva">
                                
                                {{-- Exibe a mensagem de erro vinda do Controller --}}
                                @error('nome') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            {{-- Campo: CPF --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">CPF</label>
                                {{-- O name="CPF" deve ser idêntico ao definido na sua Migration --}}
                                <input type="text" name="CPF" 
                                    class="form-control @error('CPF') is-invalid @enderror" 
                                    value="{{ old('CPF') }}" required placeholder="000.000.000-00">
                                @error('CPF') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            {{-- Campo: E-mail --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">E-mail</label>
                                <input type="email" name="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email') }}" required placeholder="email@exemplo.com">
                                @error('email') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            {{-- Campo: Função --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold">Função / Especialidade</label>
                                <input type="text" name="funcao" 
                                    class="form-control @error('funcao') is-invalid @enderror"
                                    value="{{ old('funcao') }}" required placeholder="Ex: Cabeleireiro, Dentista, etc.">
                                @error('funcao') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>

                        <hr class="text-light">

                        <div class="d-flex justify-content-end gap-2">
                            {{-- Botão Voltar: Apenas um link estilizado --}}
                            <a href="{{ route('profissionais.index') }}" class="btn btn-light px-4">Cancelar</a>
                            
                            {{-- 
                                SINTAXE: type="submit" 
                                SEMÂNTICA: Gatilho que dispara o evento de envio do formulário.
                            --}}
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg"></i> Salvar Profissional
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection