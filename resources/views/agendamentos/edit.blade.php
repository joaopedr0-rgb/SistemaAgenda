@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3 border-0">
                    {{-- SINTAXE: $agendamento->id --}}
                    {{-- SEMÂNTICA: Exibe dinamicamente o número do registro que está sendo editado. --}}
                    <h5 class="mb-0 fw-bold text-primary">Editar Agendamento #{{ $agendamento->id }}</h5>
                </div>

                <div class="card-body p-4">
                    {{-- SINTAXE: route('nome', $id) --}}
                    {{-- SEMÂNTICA: Gera a URL de destino incluindo o ID do registro no banco. --}}
                    <form action="{{ route('agendamentos.update', $agendamento->id) }}" method="POST">
                        @csrf
                        
                        {{-- 
                          SINTAXE: @method('PUT')
                          SEMÂNTICA: "Method Spoofing" (Falsificação de Método). 
                          Como navegadores não suportam o método PUT em formulários HTML, o Laravel cria um campo oculto 
                          para avisar ao servidor: "Receba este POST, mas trate-o como um UPDATE".
                        --}}
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="cliente_id" class="form-label fw-bold">Cliente</label>
                                <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                    @foreach($clientes as $cliente)
                                        {{-- 
                                          SINTAXE: old('campo', $valor_padrao)
                                          SEMÂNTICA: Lógica de Prioridade. 
                                          1º: Se houve erro na validação, mostra o que o usuário tentou digitar (old).
                                          2º: Se o formulário acabou de carregar, mostra o que já está salvo no banco ($agendamento).
                                        --}}
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
                                {{-- 
                                  SINTAXE: \Carbon\Carbon::parse($valor)->format('H:i')
                                  SEMÂNTICA: Formatação de Tempo. 
                                  O banco de dados às vezes retorna a hora como "14:30:00". 
                                  O campo <input type="time"> exige o formato "14:30" para funcionar corretamente. 
                                  Aqui você usou o Carbon (biblioteca de data/hora) para garantir a compatibilidade.
                                --}}
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