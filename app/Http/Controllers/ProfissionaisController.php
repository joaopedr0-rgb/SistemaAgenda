<?php

/*
 * SINTAXE: namespace
 * SEMÂNTICA: Define o pacote virtual onde esta classe existe. O Laravel usa isso 
 * para localizar o arquivo automaticamente dentro da pasta App/Http/Controllers.
 */
namespace App\Http\Controllers;

// SINTAXE: use
// SEMÂNTICA: Importa o Model 'Profissional' para que possamos fazer consultas no banco de dados, 
// e a classe 'Request' para capturar os dados enviados pelo navegador.
use App\Models\Profissional;
use Illuminate\Http\Request;

/*
 * SINTAXE: class NOME extends PAI
 * SEMÂNTICA: Declaração da classe controladora para os Profissionais, herdando recursos do Controller base do Laravel.
 */
class ProfissionaisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
     * SINTAXE: public function index()
     * SEMÂNTICA: Método acessado via GET. Responsável por buscar a lista completa de profissionais e enviá-la para a tela.
     */
    public function index()
    {
        /*
         * SINTAXE: Model::all()
         * SEMÂNTICA: O Eloquent dispara um "SELECT * FROM profissionais" no banco de dados 
         * e guarda o resultado (uma Collection de objetos) na variável $profissionais.
         */
        $profissionais = Profissional::all();
        
        /*
         * SINTAXE: view('caminho', compact('variavel'))
         * SEMÂNTICA: Carrega o arquivo HTML e injeta a variável $profissionais nele.
         */
        return view("profissionais.index", compact('profissionais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /*
     * SINTAXE: public function create()
     * SEMÂNTICA: Método GET. Apenas renderiza a página que contém o formulário de cadastro vazio.
     */
    public function create()
    {
        return view('profissionais.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /*
     * SINTAXE: public function store(Request $request)
     * SEMÂNTICA: Método POST. Recebe os dados digitados no formulário de criação e os salva no banco.
     */
    public function store(Request $request)
    {
        /*
         * SINTAXE: $request->validate([ 'campo' => 'regras' ])
         * SEMÂNTICA: Faz a validação estrita. O Laravel só avança se todas as regras passarem.
         * 'unique:profissionais,CPF' garante que não haverão dois profissionais com o mesmo CPF na tabela.
         * Os dados aprovados ficam salvos dentro da variável $validated.
         */
        $validated = $request->validate([
            'nome' => 'required',
            'CPF' => 'required|unique:profissionais,CPF',
            'email' => 'required|email|unique:profissionais,email',
            'funcao' => 'required',
            'status' => 'nullable', // Pode vir vazio sem gerar erro.
        ]);

        /*
         * SINTAXE: Model::create($array_seguro)
         * SEMÂNTICA: Transforma o array de dados validados em um registro real no banco de dados (INSERT).
         */
        Profissional::create($validated);
        
        /*
         * SINTAXE: redirect()->route('nome_da_rota')
         * SEMÂNTICA: Redireciona o usuário para a tela de listagem após salvar, evitando reenvio acidental de dados.
         */
        return redirect()->route('profissionais.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    /*
     * SINTAXE: public function edit(Profissional $profissional)
     * SEMÂNTICA: Método GET. Usa "Route Model Binding" (o Laravel pega o ID na URL e já injeta o objeto do banco aqui). 
     * Retorna a tela de edição preenchida com os dados desse profissional.
     */
    public function edit(Profissional $profissional)
    {
        return view('profissionais.edit', compact('profissional'));
    }

    /**
     * Update the specified resource in storage.
     */
    /*
     * SINTAXE: public function update(Request $request, Profissional $profissional)
     * SEMÂNTICA: Método PUT/PATCH. Recebe os novos dados do formulário e o registro atual para atualizar o banco.
     */
    public function update(Request $request, Profissional $profissional)
    {
        /*
         * SINTAXE: $objeto->update($array_com_dados)
         * SEMÂNTICA: Atualiza o registro no banco com os dados vindos do formulário ($request->all()).
         * Obs de estudo: Como o código possui duas linhas idênticas abaixo, o Laravel executará o "UPDATE" 
         * no banco de dados duas vezes seguidas com os mesmos dados. Isso não quebra o sistema, 
         * mas em um ambiente de produção o ideal é manter apenas uma.
         */
        $profissional->update($request->all());
        $profissional->update($request->all());
        
        /*
         * SINTAXE/SEMÂNTICA: Volta para a página de listagem geral após a edição.
         */
        return redirect()->route('profissionais.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    // O nome da variável $profissional deve ser exatamente esse se você usa Route::resource
    // No seu ProfissionalController.php
    /*
     * SINTAXE: public function destroy($id)
     * SEMÂNTICA: Método DELETE. Diferente dos outros métodos acima, aqui você optou por NÃO usar o 
     * "Route Model Binding". Você está recebendo apenas o número do ID (ex: 5) vindo da URL.
     */
    public function destroy($id) // Recebe apenas o ID
    {
        /*
         * SINTAXE: Model::find($id)
         * SEMÂNTICA: Vai no banco de dados e faz um "SELECT * FROM profissionais WHERE id = $id".
         * Se encontrar, retorna o objeto. Se não encontrar, retorna null.
         */
        $profissional = Profissional::find($id);

        /*
         * SINTAXE: if ($variavel)
         * SEMÂNTICA: Verifica se o profissional realmente foi encontrado no banco de dados antes de tentar excluir.
         */
        if ($profissional) {
            /*
             * SINTAXE: $objeto->delete()
             * SEMÂNTICA: Executa a exclusão (DELETE) deste registro específico no banco.
             */
            $profissional->delete();
            
            /*
             * SINTAXE/SEMÂNTICA: Redireciona com uma mensagem de "success" anexada à sessão.
             */
            return redirect()->route('profissionais.index')->with('success', 'Excluído!');
        }

        /*
         * SINTAXE/SEMÂNTICA: Se o 'if' falhar (ou seja, tentaram deletar um ID que não existe), 
         * o código cai aqui e redireciona de volta com uma mensagem de erro ("error").
         */
        return redirect()->route('profissionais.index')->with('error', 'Não encontrado.');
    }
}