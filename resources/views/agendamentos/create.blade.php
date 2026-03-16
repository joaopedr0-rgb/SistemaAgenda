@extends('layouts.app') 
{{-- 
  SINTAXE: @extends
  SEMÂNTICA: "Herança de Layout". Diz ao Laravel que esta página deve ser "montada" dentro do arquivo layouts/app.blade.php, 
  aproveitando o cabeçalho, menu e rodapé que já existem lá.
--}}

@section('content')
{{-- 
  SINTAXE: @section('nome')
  SEMÂNTICA: Define o "buraco" no layout pai onde todo o código abaixo será injetado. 
--}}

<div class="container py-4">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3 border-0">
               <h5 class="mb-0 fw-bold text-primary">Realizar Agendamento</h5>
            </div>

            <div class="card-body p-4">
               {{-- 
                 SINTAXE: {{ route('nome.rota') }}
                 SEMÂNTICA: Gera a URL correta automaticamente. Se você mudar a URL no arquivo de rotas, 
                 o formulário continua funcionando sem você precisar mexer aqui.
               --}}
               <form action="{{ route('agendamentos.store') }}" method="POST">
                  
                  @csrf
                  {{-- 
                    SINTAXE: @csrf
                    SEMÂNTICA: Segurança Vital! Gera um campo oculto com um token único. 
                    O Laravel bloqueia qualquer envio de formulário que não tenha esse token, protegendo contra ataques de falsificação (CSRF).
                  --}}

                  <div class="row">
                      <div class="col-md-12 mb-3">
                          <label for="cliente_id" class="form-label fw-bold">Cliente</label>
                          
                          {{-- SINTAXE: @error('campo') is-invalid @enderror --}}
                          {{-- SEMÂNTICA: Se a validação no Controller falhar, o Bootstrap aplica uma borda vermelha no campo automaticamente. --}}
                          <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                              <option value="">Selecione o Cliente</option>
                              
                              @foreach($clientes as $cliente)
                                  {{-- 
                                    SINTAXE: @foreach ... @endforeach
                                    SEMÂNTICA: Laço de repetição. Percorre a lista de clientes enviada pelo Controller e cria uma <option> para cada um.
                                    
                                    SINTAXE: {{ old('campo') == $id ? 'selected' : '' }}
                                    SEMÂNTICA: "Memória do Formulário". Se houver erro em outro campo, o Laravel mantém o cliente que você já tinha selecionado antes, 
                                    evitando que o usuário tenha que preencher tudo de novo.
                                  --}}
                                  <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                      {{ $cliente->nome }}
                                  </option>
                              @endforeach
                          </select>
                          
                          @error('cliente_id')
                              <div class="invalid-feedback">{{ $message }}</div>
                              {{-- SEMÂNTICA: Exibe a mensagem de erro específica (ex: "O campo cliente é obrigatório"). --}}
                          @enderror
                      </div>

                      <div class="col-md-12 mb-3">
                          <label for="profissional_id" class="form-label fw-bold">Profissional</label>
                          <select name="profissional_id" id="profissional_id" class="form-select @error('profissional_id') is-invalid @enderror" required>
                              <option value="">Selecione o Profissional</option>
                              @foreach($profissionais as $profissional)
                                  <option value="{{ $profissional->id }}" {{ old('profissional_id') == $profissional->id ? 'selected' : '' }}>
                                      {{ $profissional->nome }}
                                  </option>
                              @endforeach
                          </select>
                          @error('profissional_id')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>

                      <div class="col-md-12 mb-3">
                          <label for="servico_id" class="form-label fw-bold">Serviço</label>
                          <select name="servico_id" id="servico_id" class="form-select @error('servico_id') is-invalid @enderror" required>
                              <option value="">Selecione o Serviço</option>
                              @foreach($servicos as $servico)
                                  <option value="{{ $servico->id }}" {{ old('servico_id') == $servico->id ? 'selected' : '' }}>
                                      {{ $servico->nome }}
                                  </option>
                              @endforeach
                          </select>
                          @error('servico_id')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>

                      <div class="col-md-6 mb-3">
                          <label for="data" class="form-label fw-bold">Data</label>
                          {{-- SINTAXE: value="{{ old('data') }}" --}}
                          {{-- SEMÂNTICA: Mantém a data digitada caso o formulário retorne com erro de validação. --}}
                          <input type="date" name="data" id="data" class="form-control @error('data') is-invalid @enderror" value="{{ old('data') }}" required>
                          @error('data')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>

                      <div class="col-md-6 mb-3">
                          <label for="hora" class="form-label fw-bold">Hora</label>
                          <input type="time" name="hora" id="hora" class="form-control @error('hora') is-invalid @enderror" value="{{ old('hora') }}" required>
                          @error('hora')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>

                      <div class="col-md-12 d-flex justify-content-end mt-3">
                          <a href="{{ route('agendamentos.index') }}" class="btn btn-light me-2">Cancelar</a>
                          <button type="submit" class="btn btn-primary px-4">Salvar Agendamento</button>
                      </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection