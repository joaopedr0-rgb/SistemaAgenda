<?php

namespace App\Http\Controllers;

use App\Models\Cliente; // Importa o Model para interagir com o Banco de Dados
use Illuminate\Http\Request; // Importa a classe que lida com dados de formulários/URL

class ClientesController extends Controller
{
    /**
     * LISTAR CLIENTES (Read)
     * Sintaxe: Cliente::orderBy(...)->get()
     * Semântica: O Eloquent (ORM) faz um "SELECT * FROM clientes ORDER BY..." 
     * e retorna uma Coleção. O compact('clientes') passa essa variável para a View index.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('created_at', 'desc')->get();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * FORMULÁRIO DE CRIAÇÃO
     * Semântica: Apenas carrega a página com o formulário vazio.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * SALVAR NO BANCO (Create)
     * Sintaxe: $request->validate([...])
     * Semântica: Camada de segurança. Se o 'nome' for menor que 3 letras, o Laravel 
     * interrompe aqui e volta para o formulário com erros.
     * O unique:clientes,email evita duplicidade de e-mail no banco.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'  => 'required|min:3',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'nullable'
        ]);

        // Mass Assignment: Cria o registro com todos os dados vindos do form.
        Cliente::create($request->all());

        // Redirecionamento com mensagem Flash (sessão temporária)
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * FORMULÁRIO DE EDIÇÃO
     * Sintaxe: public function edit(Cliente $cliente)
     * Semântica: Route Model Binding. O Laravel recebe o ID pela URL, faz o 
     * "SELECT * FROM clientes WHERE id = ?" automaticamente e já te entrega o objeto pronto.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * ATUALIZAR DADOS (Update)
     * Sintaxe: unique:clientes,email,' . $cliente->id
     * Semântica: Diz ao validador para ignorar o e-mail do próprio cliente atual, 
     * caso contrário, ele diria que o e-mail "já existe" ao tentar salvar sem alterá-lo.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nome'  => 'required|min:3',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
                         ->with('success', 'Dados atualizados!');
    }

    /**
     * EXCLUSÃO (Delete)
     * Sintaxe: $cliente->delete()
     * Semântica: Remove o registro do banco de dados. 
     * Como usamos Route Model Binding, se o ID não existir, ele já retorna erro 404 sozinho.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente removido.');
    }
}