@extends('layouts.app')

@section('content')
    
    <div class="d-flex align-items-center justify-content-center">
        <div class="card shadow-sm p-4 border-0 w-100" style="max-width: 450px;">
            <h2 class="text-center mb-4 fw-bold text-dark">Criar Nova Conta</h2>

            {{-- Exibição de Erros --}}
            {{-- 
              SINTAXE: @if ($errors->any())
              SEMÂNTICA: O Laravel armazena falhas de validação (como e-mail repetido ou senha curta) 
              em uma variável global chamada '$errors'. Este bloco garante que o usuário saiba 
              exatamente por que o cadastro não foi concluído.
            --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulário Apontando para o Controller --}}
            {{-- 
              SINTAXE: route('cadastro')
              SEMÂNTICA: Envia os dados para a rota POST que você definiu. 
              Geralmente, essa rota chama um método 'store' no seu LoginController ou RegisterController.
            --}}
            <form action="{{ route('cadastro') }}" method="POST">
                @csrf
                {{-- O @csrf é obrigatório aqui para evitar que robôs externos tentem criar contas no seu sistema. --}}

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold text-secondary">Nome Completo</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold text-secondary">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-4">
                    <label for="cep" class="form-label fw-bold text-secondary">CEP</label>
                    <input type="text" class="form-control" name="cep" id="cep" value="{{ old('cep') }}" required>
                </div>
                <div class="mb-4">
                    <label for="bairro" class="form-label fw-bold text-secondary">Bairro</label>
                    <input type="text" class="form-control" name="bairro" id="bairro" value="{{ old('bairro') }}" required>
                </div>
                <div class="mb-4">
                    <label for="cidade" class="form-label fw-bold text-secondary">Cidade</label>
                    <input type="text" class="form-control" name="cidade" id="cidade" value="{{ old('cidade') }}" required>
                </div>
                <div class="mb-4">
                    <label for="estado" class="form-label fw-bold text-secondary">Estado</label>
                    <input type="text" class="form-control" name="estado" id="estado" value="{{ old('estado') }}" required>
                </div>
                <div class="mb-4">
                    <label for="numero" class="form-label fw-bold text-secondary">Número</label>
                    <input type="text" class="form-control" name="numero" id="numero" value="{{ old('numero') }}" required>
                </div>
                <div class="mb-4">
                    <label for="logradouro" class="form-label fw-bold text-secondary">Logradouro</label>
                    <input type="text" class="form-control" name="logradouro" id="logradouro" value="{{ old('logradouro') }}" required>
                </div>
                 <div class="mb-4">
                    <label for="password" class="form-label fw-bold text-secondary">Senha</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold text-secondary">Confirmar Senha</label>
                    {{-- 
                      SINTAXE: name="password_confirmation"
                      SEMÂNTICA: Regra de Nomenclatura do Laravel. 
                      Ao usar o sufixo '_confirmation', a regra de validação 'confirmed' no Controller 
                      compara automaticamente este campo com o campo 'password'. Se forem diferentes, o Laravel barra o envio.
                    --}}
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                    Cadastrar
                </button>
            </form>

            <div class="mt-4 text-center">
                <p class="text-muted mb-0">Já tem uma conta? 
                    <a href="{{ route('dashboard.index') }}" class="text-primary fw-bold text-decoration-none">
                        Faça login aqui
                    </a>
                </p>
            </div>
        </div>
    </div>

@endsection