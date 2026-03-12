<?php
/*
SINTAXE: <?php 
SEMÂNTICA: Tag de abertura do PHP. Informa ao servidor que todo o código a seguir deve ser processado como PHP. 
*/

namespace App\Http\Controllers;
/*
SINTAXE: namespace Caminho\Do\Diretorio;
SEMÂNTICA: Define o "endereço virtual" desta classe. Evita conflitos de nomes caso existam outras classes com o mesmo nome.
*/

use App\Models\Servico;
use Illuminate\Http\Request;
/*
SINTAXE: use Caminho\Da\Classe;
SEMÂNTICA: Importa classes externas para dentro deste arquivo. 
- A primeira importa o Model 'Servico' (para o banco de dados).
- A segunda importa a classe 'Request' (para capturar os dados do formulário).
*/

class ServicosController extends Controller
{
    /*
    SINTAXE: class NomeDaClasse extends ClassePai
    SEMÂNTICA: Declaração da classe principal. 'extends Controller' herda funções base de um Controller padrão do Laravel.
    */

    public function index()
    {
        /*
        SINTAXE: public function nomeMetodo()
        SEMÂNTICA: Método para exibir a lista principal de registros.
        */

        $servicos = Servico::all();
        /*
        SINTAXE: $variavel = Model::all();
        SEMÂNTICA: Faz um "SELECT * FROM servicos" no banco e guarda na variável $servicos.
        */

        return view('servicos.index', compact('servicos'));
        /*
        SINTAXE: return view('arquivo', compact('variavel'));
        SEMÂNTICA: Renderiza o HTML. O 'compact' envia a variável $servicos para dentro da View.
        */
    }

    public function create()
    {
        /*
        SEMÂNTICA: Método responsável apenas por exibir a tela de cadastro.
        */
        return view('servicos.create');
    }

    public function store(Request $request)
    {
        /*
        SINTAXE: public function store(Request $request)
        SEMÂNTICA: O '$request' captura os dados que o usuário enviou no formulário (POST).
        */

        $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric',
            'duracao'   => 'required|integer|min:1',
            'status'    => 'required|string|in:Ativo,Inativo',
            'descricao' => 'required|string|max:255',
        ]);
        /*
        SINTAXE: $request->validate([ 'campo' => 'regras' ]);
        SEMÂNTICA: Filtro de segurança. Se falhar, devolve o usuário para a tela anterior com erro.
        */

        Servico::create($request->all());
        /*
        SINTAXE: Model::create($request->all());
        SEMÂNTICA: Pega os dados validados e insere no banco (INSERT INTO).
        */

        return redirect()->route('servicos.index')->with('success', 'Serviço criado com sucesso.');
        /*
        SINTAXE: return redirect()->route('rota')->with('chave', 'mensagem');
        SEMÂNTICA: Redireciona para a listagem enviando uma mensagem de sucesso temporária.
        */
    }

    public function edit(Servico $servico)
    {
        /*
        SINTAXE: public function edit(Model $variavel)
        SEMÂNTICA: Route Model Binding. Busca o ID na URL e injeta o objeto $servico aqui.
        */

        return view('servicos.edit', compact('servico'));
    }

    public function update(Request $request, Servico $servico)
    {
        /*
        SEMÂNTICA: Recebe os dados novos do formulário ($request) e o serviço antigo do banco ($servico).
        */

        $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric',
            'duracao'   => 'required|integer|min:1', 
            'status'    => 'required|string|in:Ativo,Inativo',
            'descricao' => 'required|string|max:255',
        ]);

        $servico->update($request->all());
        /*
        SINTAXE: $objeto->update(array);
        SEMÂNTICA: Executa um "UPDATE servicos SET..." no banco de dados.
        */

        return redirect()->route('servicos.index')->with('success', 'Serviço atualizado com sucesso.');
    }

    public function destroy(Servico $servico)
    {
        /*
        SEMÂNTICA: Recebe o ID da URL, encontra o serviço e prepara para exclusão.
        */

        $servico->delete();
        /*
        SINTAXE: $objeto->delete();
        SEMÂNTICA: Executa "DELETE FROM servicos WHERE id = ...".
        */

        return redirect()->route('servicos.index')->with('success', 'Serviço deletado com sucesso.');
    }
}