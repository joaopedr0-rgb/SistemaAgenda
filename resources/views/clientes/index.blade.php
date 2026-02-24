{{-- 
    SINTAXE: @extends('caminho.nome_do_arquivo')
    SEMÂNTICA: Implementa o conceito de Herança de Templates. 
    Este arquivo diz ao Laravel para usar o "esqueleto" (layout) definido em 'resources/views/layouts/app.blade.php'.
--}}
@extends('layouts.app')

{{-- 
    SINTAXE: @section('nome') ... @endsection
    SEMÂNTICA: Define um bloco de conteúdo que será injetado no local correspondente 
    ao comando @yield('content') dentro do arquivo pai (o layout).
--}}
@section('content')

<div class="card border-0 shadow-sm">
    
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Clientes Registrados</h5>
        
        {{-- 
            SINTAXE: {{ route('nome.da.rota') }}
            SEMÂNTICA: Função auxiliar (helper) que gera a URL completa dinamicamente. 
            Se você mudar o prefixo da URL no arquivo de rotas, o link não quebra.
        --}}
        <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm px-3">+ Novo</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Nome</th>
                    <th>Contato</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                
                {{-- 
                    SINTAXE: @forelse($colecao as $item) ... @empty ... @endforelse
                    SEMÂNTICA: É um loop "inteligente". Tenta percorrer a lista de $clientes. 
                    Se a lista estiver vazia (sem registros), ele ignora o loop e executa o que está no @empty.
                --}}
                @forelse($clientes as $cliente)
                <tr>
                    <td class="ps-4">
                        {{-- 
                            SINTAXE: {{ $variavel }}
                            SEMÂNTICA: Imprime o dado na tela (eco seguro). 
                            O Blade aplica automaticamente htmlspecialchars() para evitar ataques de XSS (Cross-Site Scripting).
                        --}}
                        <div class="fw-bold">{{ $cliente->nome }}</div>
                        <small class="text-muted">ID: #{{ $cliente->id }}</small>
                    </td>
                    <td>
                        <div>{{ $cliente->email }}</div>
                        
                        {{-- 
                            SINTAXE: $a ?? 'padrão' (Operador de Coalescência Nula do PHP)
                            SEMÂNTICA: "Tente exibir o telefone. Se ele for null ou não existir, exiba 'Sem telefone'".
                        --}}
                        <small class="text-muted">{{ $cliente->telefone ?? 'Sem telefone' }}</small>
                    </td>
                    <td>
                        {{-- 
                            SINTAXE: Operador Ternário dentro de chaves Blade.
                            SEMÂNTICA: Lógica visual dinâmica. Se o status for 'ativo', aplica a classe 'bg-success' (verde), 
                            caso contrário, aplica 'bg-secondary' (cinza).
                        --}}
                        <span class="badge rounded-pill {{ $cliente->status == 'ativo' ? 'bg-success' : 'bg-secondary' }}">
                            
                            {{-- SINTAXE: ucfirst() -> Função do PHP para tornar a primeira letra maiúscula. --}}
                            {{ ucfirst($cliente->status) }}
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        
                        {{-- 
                            SINTAXE: Formulário de exclusão.
                            SEMÂNTICA: Operações que alteram dados (Delete/Update) devem ser feitas via formulário 
                            e nunca por links simples (GET), para garantir a integridade e segurança.
                        --}}
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                            
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                            
                            {{-- 
                                SINTAXE: @csrf
                                SEMÂNTICA: Cross-Site Request Forgery. Gera um token único oculto. 
                                O Laravel valida este token no servidor para garantir que a requisição veio do seu próprio site.
                            --}}
                            @csrf
                            
                            {{-- 
                                SINTAXE: @method('DELETE')
                                SEMÂNTICA: "Falsificação de método". Como navegadores HTML só aceitam GET e POST, 
                                o Blade envia um campo oculto que avisa ao roteador do Laravel para tratar esta ação como DELETE.
                            --}}
                            @method('DELETE')
                            
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este cliente?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                
                @empty
                {{-- Exibido apenas se a variável $clientes estiver vazia --}}
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">Nenhum cliente cadastrado.</td>
                </tr>
                
                @endforelse
                
            </tbody>
        </table>
    </div>
</div>

@endsection