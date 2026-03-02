@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <h4 class="text-center mb-4 fw-bold">
                    Acesso ao Sistema
                </h4>

                <form method="POST" action="{{ route('login.authenticate') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Digite seu e-mail"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Senha --}}
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Digite sua senha"
                            required
                        >
                    </div>

                    {{-- Botão --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Entrar
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection