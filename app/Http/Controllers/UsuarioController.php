<?php

/*
 * SINTAXE: namespace
 * SEMÂNTICA: Define o pacote virtual da classe, permitindo que o Laravel a encontre pelo padrão PSR-4 de autoloading.
 */
namespace App\Http\Controllers;

// SINTAXE: use
// SEMÂNTICA: Importa as classes necessárias. O Model 'User' para o banco, 'Request' para os dados do formulário e 'Hash' para a criptografia da senha.
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/*
 * SINTAXE: class Nome extends Pai
 * SEMÂNTICA: Cria o controlador 'UsuarioController' herdando os recursos do Controller padrão do framework.
 */
class UsuarioController extends Controller
{
    
    /*
     * SINTAXE: public function index()
     * SEMÂNTICA: Método acessado via GET. Sua responsabilidade é listar os usuários do sistema.
     */
    public function index()
    {
        /*
         * SINTAXE: Model::where('coluna', valor)->get()
         * SEMÂNTICA: O Eloquent traduz isso para "SELECT * FROM users WHERE is_admin = false".
         * É um excelente uso de filtro! Ele busca no banco *apenas* os usuários que são recepcionistas (is_admin falso) 
         * e guarda essa "Collection" (lista) na variável $usuarios.
         */
        $usuarios = User::where('is_admin', false)->get();
        
        /*
         * SINTAXE: return view('caminho', compact('variavel'))
         * SEMÂNTICA: Renderiza a tela index e injeta a lista filtrada ($usuarios) para ser usada no HTML.
         */
        return view('usuarios.index', compact('usuarios')); // Criar uma view para listar os usuários
    }

   //Create Usuarios 
    /*
     * SINTAXE: public function create()
     * SEMÂNTICA: Método GET. Entrega a página de formulário em branco para cadastrar novos usuários.
     */
    public function create()
    {
        /*
         * SINTAXE: return view('caminho')
         * SEMÂNTICA: Apenas carrega o HTML. 
         * (Nota de estudo: o seu comentário original menciona que o Admin poderá escolher o tipo, mas no método store abaixo, o sistema está forçando todos a serem recepcionistas. Vale a pena revisar essa regra de negócio depois!).
         */
        return view('usuarios.create'); //criará uma view específ:ica para cadastro de usuários, onde o Admin poderá escolher o tipo (Admin ou Recepcionista)
    }

    // Salva a recepcionista no banco
    /*
     * SINTAXE: public function store(Request $request)
     * SEMÂNTICA: Método POST. Recebe os dados do formulário preenchido e tenta inseri-los no banco.
     */
    public function store(Request $request)
    {
        /*
         * SINTAXE: $request->validate([ regras ])
         * SEMÂNTICA: Protege a aplicação. Garante que campos obrigatórios existam, que o email seja válido e único, 
         * e que a senha tenha no mínimo 8 caracteres e seja confirmada (campo password_confirmation no HTML).
         */
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
           
        ]);

        /*
         * SINTAXE: User::create([ array associativo ])
         * SEMÂNTICA: Faz o "INSERT INTO" no banco de dados. Mapeia os dados validados ($dados) para as colunas da tabela.
         */
        User::create([
        'name' => $dados['name'],
        'email' => $dados['email'],
        
        /*
         * SINTAXE: Hash::make(string)
         * SEMÂNTICA: Criptografa a senha usando o algoritmo Bcrypt antes de salvar no banco de dados. Nunca salva em texto limpo.
         */
        'password' => Hash::make($dados['password']),
        
        /*
         * SINTAXE: 'coluna' => boolean
         * SEMÂNTICA: Força explicitamente no código que o usuário criado por esta rota será uma recepcionista, ignorando o que quer que tenha vindo do formulário.
         */
        'is_admin' => false, // Garante que é recepcionista no banco
    ]);

        
        // Redireciona o Admin de volta para a lista de usuários com uma mensagem de sucesso
        /*
         * SINTAXE: redirect()->route('nome')->with('chave', 'mensagem')
         * SEMÂNTICA: Após criar, joga o usuário de volta para a lista (index) e acopla uma mensagem Flash na sessão para o HTML exibir.
         */
        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

    /*
     * SINTAXE: public function edit(User $user)
     * SEMÂNTICA: Route Model Binding. Busca o usuário que será editado pela URL (ex: /usuarios/3/edit) e o injeta na variável $user.
     */
    public function edit(User $user)
    {
      /*
       * SINTAXE: return view('view', compact('variavel'))
       * SEMÂNTICA: Renderiza o formulário preenchido.
       * ⚠️ DICA DE ESTUDO (Atenção ao testar): O compact('usuarios') tenta enviar uma variável chamada $usuarios, mas o parâmetro recebido pelo método se chama $user. Quando for testar no navegador, isso gerará um erro "Undefined variable $usuarios". Para corrigir no futuro, você precisará mudar para compact('user').
       */
      return view('usuarios.edit',compact('usuarios'));
    }

    /*
     * SINTAXE: public function update(Request $request, User $user)
     * SEMÂNTICA: Método PUT/PATCH. Recebe o usuário atualizado ($request) e o usuário alvo no banco ($user).
     */
    public function update(Request $request, User $user)
    {
        /*
         * SINTAXE: $objeto->update($array_de_dados)
         * SEMÂNTICA: Dispara o "UPDATE" no banco.
         * ⚠️ DICA DE ESTUDO: Assim como no Controller de Profissionais, a linha está duplicada. O código funcionará, mas fará o "UPDATE" duas vezes seguidas no banco.
         */
        $user->update($request->all());
        $user->update($request->all());
        
        /*
         * SINTAXE/SEMÂNTICA: Redireciona de volta para a lista.
         */
        return redirect()->route('usuarios.index');

    }

    /*
     * SINTAXE: public function destroy(User $usuarios)
     * SEMÂNTICA: Método DELETE. Route Model Binding injeta o usuário a ser deletado diretamente na variável $usuarios.
     */
    public function destroy(User $usuarios)
    {
        /*
         * SINTAXE: $objeto->delete()
         * SEMÂNTICA: Executa a exclusão deste usuário do banco de dados (DELETE FROM users WHERE id = ?).
         */
        $usuarios->delete();

        // 2. Apaga o registo

        // 3. Redireciona de volta para a lista com uma mensagem de sucesso
        /*
         * SINTAXE/SEMÂNTICA: Redireciona para o index passando a confirmação de que a recepcionista foi removida.
         */
        return redirect()->route('usuarios.index')->with('success', 'Recepcionista excluída com sucesso!');
    }
}