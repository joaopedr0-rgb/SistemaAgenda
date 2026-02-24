@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">Novo Cliente</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profissionais.index') }}" method="POST">


                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Nome Completo do Profissional</label>
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                value="{{ old('nome') }}" required>

                            @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror


                </form>

            </div>

        </div>

    </div>

@endsection