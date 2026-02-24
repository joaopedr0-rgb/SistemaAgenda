{{-- 
    SINTAXE: @extends('caminho.arquivo')
    SEMÂNTICA: Implementa o conceito de Herança de Templates. 
    Diz ao Laravel que este arquivo é "filho" do layouts/app.blade.php e deve ser inserido nele.
--}}
@extends('layouts.app')

{{-- 
    SINTAXE: @section('nome') ... @endsection
    SEMÂNTICA: Define um bloco de conteúdo. Tudo aqui dentro será injetado no 
    local onde houver um @yield('content') no arquivo pai (layout).
--}}
@section('content')

<div class="card border-0 shadow-sm">
    
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Clientes Registrados</h5>
        
        {{-- 
            SINTAXE: {{ route('nome.da.rota') }}
            SEMÂNTICA: Helper do Laravel que gera a URL absoluta baseada no nome definido no arquivo web.php. 
            Isso evita que links quebrem se você mudar o prefixo da URL no futuro.
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
                    SINTAXE: @forelse($colecao as $item)
                    SEMÂNTICA: Um loop aprimorado. Tenta percorrer $clientes; 
                    se a coleção estiver vazia (null ou []), ele pula automaticamente para o bloco @empty.
                --}}
                @forelse($clientes as $cliente)
                <tr>
                    <td class="ps-4">
                        {{-- 
                            SINTAXE: {{ $variavel }}
                            SEMÂNTICA: Echo seguro (Escaping). O Blade aplica htmlspecialchars() 
                            automaticamente para prevenir ataques de Scripts (XSS).
                        --}}
                        <div class="fw-bold">{{ $cliente->nome }}</div>
                        <small class="text-muted">ID: #{{ $cliente->id }}</small>
                    </td>
                    <td>
                        <div>{{ $cliente->email }}</div>
                        
                        {{-- 
                            SINTAXE: $a ?? $b (Null Coalesce Operator do PHP)
                            SEMÂNTICA: "Tente mostrar o telefone, se ele não existir ou for nulo, mostre a string à direita".
                        --}}
                        <small class="text-muted">{{ $cliente->telefone ?? 'Sem telefone' }}</small>
                    </td>
                    <td>
                        {{-- 
                            SINTAXE: {{ condição ? 'valor1' : 'valor2' }}
                            SEMÂNTICA: Operador ternário para lógica visual. Define a classe CSS (cor) 
                            dinamicamente com base no dado do banco.
                        --}}
                        <span class="badge rounded-pill {{ $cliente->status == 'ativo' ? 'bg-success' : 'bg-secondary' }}">
                            
                            {{-- SINTAXE: ucfirst() -> Função nativa PHP para formatar texto (Capitalize). --}}
                            {{ ucfirst($cliente->status) }}
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        
                        {{-- 
                            SINTAXE: Form com método POST apontando para uma rota que espera ID.
                            SEMÂNTICA: Ações de exclusão exigem formulários por segurança (evita deleção via URL GET).
                        --}}
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                            
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                            
                            {{-- 
                                SINTAXE: @csrf
                                SEMÂNTICA: Segurança Cross-Site Request Forgery. Gera um token único para validar 
                                que a requisição partiu do seu próprio site e não de um hacker.
                            --}}
                            @csrf
                            
                            {{-- 
                                SINTAXE: @method('DELETE')
                                SEMÂNTICA: Method Spoofing. Como navegadores só enviam GET/POST, 
                                isso avisa ao roteador do Laravel para tratar a requisição como DELETE.
                            --}}
                            @method('DELETE')
                            
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este cliente?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                
                {{-- Bloco executado apenas se a variável $clientes estiver vazia. --}}
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">Nenhum cliente cadastrado.</td>
                </tr>
                
                @endforelse
                
            </tbody>
        </table>
    </div>
</div>

@endsection