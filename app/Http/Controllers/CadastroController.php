<?php
/*
SINTAXE: <?php
SEMÂNTICA: Abertura padrão de arquivo PHP. Informa ao servidor que o código a seguir deve ser interpretado como PHP.
*/

/*
SINTAXE: namespace Caminho\Do\Diretorio;
SEMÂNTICA: Define o endereço lógico desta classe dentro do projeto Laravel, permitindo que ela seja encontrada automaticamente (autoload) sem precisarmos dar 'include' manualmente.
*/
namespace App\Http\Controllers;

/*
SINTAXE: use Caminho\Da\Classe;
SEMÂNTICA: Importa as classes necessárias para este arquivo. 'User' para acessar o banco de dados, 'Request' para capturar os dados do formulário e 'Hash' para criptografar as senhas.
*/
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/*
SINTAXE: class NomeDaClasse extends ClassePai
SEMÂNTICA: Declara o Controller que vai gerenciar o cadastro, herdando os métodos base e recursos do Controller padrão do Laravel.
*/
class CadastroController extends Controller
{

    /*
    SINTAXE: public function nomeDoMetodo()
    SEMÂNTICA: Método acessado via GET. Sua única responsabilidade é renderizar e entregar a tela (o formulário HTML) para que o usuário possa se cadastrar.
    */
    public function create()
    {
        // Sintaxe: retorna uma função auxiliar view().
        // Semântica: Carrega o arquivo HTML localizado em resources/views/cadastro/index.blade.php.
        return view('cadastro.index');
    }

    /*
     *
     * Semântica: Recebe os dados do formulário e salva no banco de dados.
     *
     */
    public function store(Request $request)
    {
        // --- ETAPA 1: VALIDAÇÃO ---
        // Sintaxe: $request->validate([regras]). 
        // Semântica: Protege o banco. Se algo falhar (ex: e-mail duplicado), o Laravel para aqui e volta com erro.
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'], // Obrigatório, texto, limite de caracteres.
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Deve ser e-mail único na tabela users.
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Mínimo 8 caracteres; exige campo 'password_confirmation'.
            'cep' => 'required|size:9',
            'logradouro' => 'required|string|max:255',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|size:2',
        ]);

        // --- ETAPA 2: CRIAÇÃO ---
        // Sintaxe: Método estático User::create([]).
        // Semântica: Transforma o array de dados em uma linha na tabela do SQL.
        User::create([
            'name' => $dados['name'],
            'email' => $dados['email'],

            // Sintaxe: Hash::make().
            // Semântica: Criptografia. Nunca salvamos a senha "limpa" por segurança.
            'password' => Hash::make($dados['password']),

            // Semântica: Define manualmente que este usuário é um Administrador.
            'is_admin' => true,
        ]);

        // --- ETAPA 3: RESPOSTA ---
        // Sintaxe: redirect()->route('nome_da_rota').
        // Semântica: Após salvar, manda o usuário para a página inicial de clientes.
        return redirect()->route('clientes.index');
    }

    /*
     SINTAXE: Recebe o Model 'User' via parâmetro (Route Model Binding).
     SEMÂNTICA: Método planejado para carregar a tela de edição de um usuário específico. Atualmente vazio.
     */
    public function edit(User $user)
    {

    }

    /*
     SINTAXE: Recebe a requisição (Request) com os dados novos e o usuário alvo (User).
     SEMÂNTICA: Método planejado para processar e salvar as edições feitas no formulário. Atualmente vazio.
     */
    public function update(Request $request, User $user)
    {

    }

    /*
    SINTAXE: Recebe o usuário alvo (User) que será deletado.
    SEMÂNTICA: Método planejado para excluir o registro selecionado do banco de dados. Atualmente vazio.
    */
    public function destroy(User $user)
    {

    }
}