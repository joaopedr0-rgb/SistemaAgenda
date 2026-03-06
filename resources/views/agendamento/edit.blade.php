@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-primary">Editar Agendamento #{{ $agendamento->id }}</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('agendamentos.update', $agendamento->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="cliente_id" class="form-label fw-bold">Cliente</label>
                                <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ (old('cliente_id', $agendamento->cliente_id) == $cliente->id) ? 'selected' : '' }}>
                                            {{ $cliente->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="profissional_id" class="form-label fw-bold">Profissional</label>
                                <select name="profissional_id" id="profissional_id" class="form-select @error('profissional_id') is-invalid @enderror" required>
                                    @foreach($profissionais as $profissional)
                                        <option value="{{ $profissional->id }}" {{ (old('profissional_id', $agendamento->profissional_id) == $profissional->id) ? 'selected' : '' }}>
                                            {{ $profissional->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('profissional_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="data" class="form-label fw-bold">Data</label>
                                <input type="date" name="data" id="data" class="form-control @error('data') is-invalid @enderror" value="{{ old('data', $agendamento->data) }}" required>
                                @error('data')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="hora" class="form-label fw-bold">Hora</label>
                                <input type="time" name="hora" id="hora" class="form-control @error('hora') is-invalid @enderror" value="{{ old('hora', \Carbon\Carbon::parse($agendamento->hora)->format('H:i')) }}" required>
                                @error('hora')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 d-flex justify-content-end mt-3">
                                <a href="{{ route('agendamentos.index') }}" class="btn btn-light me-2">Voltar</a>
                                <button type="submit" class="btn btn-primary px-4">Atualizar Agendamento</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection