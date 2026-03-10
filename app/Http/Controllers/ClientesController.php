<?php

/*
 * SINTAXE: namespace
 * SEMÂNTICA: Define o endereço lógico desta classe no sistema de arquivos do Laravel (padrão PSR-4), 
 * permitindo que o framework a encontre e carregue automaticamente.
 */
namespace App\Http\Controllers;

// SINTAXE: use
// SEMÂNTICA: Importa o Model 'Cliente' para interagir com a tabela de clientes no Banco de Dados usando o Eloquent ORM.
use App\Models\Cliente; 

// SINTAXE: use
// SEMÂNTICA: Importa a classe 'Request' que captura e manipula todos os dados da requisição HTTP (inputs de formulários, parâmetros da URL, etc).
use Illuminate\Http\Request; 

/*
 * SINTAXE: class Nome extends Pai
 * SEMÂNTICA: Cria a classe ClientesController herdando as funcionalidades base do Controller do Laravel.
 */
class ClientesController extends Controller
{
    /**
     * LISTAR CLIENTES (Read)
     * SINTAXE: public function index()
     * SEMÂNTICA: Método acessado via requisição GET. Responsável por buscar todos os registros e exibi-los.
     */
    public function index()
    {
        /*
         * SINTAXE: Cliente::orderBy('coluna', 'direção')->get()
         * SEMÂNTICA: O Eloquent (ORM do Laravel) traduz isso para "SELECT * FROM clientes ORDER BY created_at DESC" 
         * e retorna uma 'Collection' (uma lista de objetos Cliente, do mais recente para o mais antigo).
         */
        $clientes = Cliente::orderBy('created_at', 'desc')->get();
        
        /*
         * SINTAXE: return view('caminho', compact('variavel'))
         * SEMÂNTICA: Renderiza o arquivo resources/views/clientes/index.blade.php. 
         * O compact('clientes') empacota a variável $clientes em um array para que o HTML possa acessá-la.
         */
        return view('clientes.index', compact('clientes'));
    }

    /**
     * FORMULÁRIO DE CRIAÇÃO
     * SINTAXE: public function create()
     * SEMÂNTICA: Acessado via GET. Apenas carrega e exibe a página com o formulário HTML vazio para o usuário preencher.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * SALVAR NO BANCO (Create)
     * SINTAXE: public function store(Request $request)
     * SEMÂNTICA: Acessado via POST. Recebe os dados disparados pelo formulário de criação e os insere no banco.
     */
    public function store(Request $request)
    {
        /*
         * SINTAXE: $request->validate([ 'campo' => 'regras' ])
         * SEMÂNTICA: Camada de segurança obrigatória. Se o 'nome' for menor que 3 letras, o Laravel 
         * interrompe o fluxo aqui mesmo e redireciona de volta para o formulário mostrando os erros.
         * O 'unique:clientes,email' é uma regra de banco de dados que impede o cadastro de um e-mail já existente na tabela 'clientes'.
         * O 'nullable' significa que o campo 'telefone' não é obrigatório, mas se for preenchido, passará limpo.
         */
        $request->validate([
            'nome'  => 'required|min:3',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'nullable'
        ]);

        /*
         * SINTAXE: Cliente::create($request->all())
         * SEMÂNTICA: Mass Assignment (Atribuição em Massa). Cria o registro no banco com todos os dados vindos do form.
         * Atenção: Para isso funcionar sem falhas de segurança, o Model Cliente DEVE ter a propriedade $fillable configurada com 'nome', 'email' e 'telefone'.
         */
        // Mass Assignment: Cria o registro com todos os dados vindos do form.
        Cliente::create($request->all());

        /*
         * SINTAXE: redirect()->route('nome')->with('chave', 'mensagem')
         * SEMÂNTICA: Redirecionamento após o POST (evita que o usuário dê F5 e reenvie o formulário).
         * Envia o usuário de volta para a lista (clientes.index) com uma mensagem Flash (sessão temporária de 1 request) de sucesso.
         */
        // Redirecionamento com mensagem Flash (sessão temporária)
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * FORMULÁRIO DE EDIÇÃO
     * SINTAXE: public function edit(Cliente $cliente)
     * SEMÂNTICA: Route Model Binding. O Laravel recebe o ID pela URL (ex: /clientes/10/edit), faz o 
     * "SELECT * FROM clientes WHERE id = 10" automaticamente nos bastidores e já te entrega o objeto pronto na variável $cliente.
     */
    public function edit(Cliente $cliente)
    {
        /*
         * SINTAXE: compact('cliente')
         * SEMÂNTICA: Envia o objeto encontrado para a view resources/views/clientes/edit.blade.php, 
         * permitindo que o HTML preencha os inputs com os dados atuais do cliente.
         */
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * ATUALIZAR DADOS (Update)
     * SINTAXE: public function update(Request $request, Cliente $cliente)
     * SEMÂNTICA: Acessado via PUT/PATCH. Recebe os dados novos do formulário ($request) e o cliente que será modificado ($cliente).
     */
    public function update(Request $request, Cliente $cliente)
    {
        /*
         * SINTAXE: 'unique:tabela,coluna,' . $id_a_ignorar
         * SEMÂNTICA: Diz ao validador para garantir que o e-mail seja único, MAS para ignorar o e-mail do próprio cliente atual.
         * Caso contrário, se o usuário mudasse apenas o telefone e deixasse o e-mail igual, o Laravel diria que o e-mail "já existe" e bloquearia a edição.
         */
        $request->validate([
            'nome'  => 'required|min:3',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
        ]);

        /*
         * SINTAXE: $objeto->update($array_de_dados)
         * SEMÂNTICA: Executa um comando "UPDATE clientes SET ... WHERE id = ?" no banco de dados usando os novos dados do formulário.
         */
        $cliente->update($request->all());

        /*
         * SINTAXE/SEMÂNTICA: Redireciona para a tabela listagem com mensagem de sucesso.
         */
        return redirect()->route('clientes.index')
                         ->with('success', 'Dados atualizados!');
    }

    /**
     * EXCLUSÃO (Delete)
     * SINTAXE: public function destroy(Cliente $cliente)
     * SEMÂNTICA: Acessado via DELETE. Remove o registro selecionado do banco de dados. 
     * Como usamos Route Model Binding, se alguém tentar deletar um ID que não existe na URL, o Laravel já retorna erro 404 sozinho antes mesmo de entrar no método.
     */
    public function destroy(Cliente $cliente)
    {
        /*
         * SINTAXE: $objeto->delete()
         * SEMÂNTICA: Executa o "DELETE FROM clientes WHERE id = ?" (ou apenas marca como deletado se usar SoftDeletes no Model).
         */
        $cliente->delete();
        
        /*
         * SINTAXE/SEMÂNTICA: Retorna à listagem informando que a exclusão foi concluída.
         */
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente removido.');
    }
}