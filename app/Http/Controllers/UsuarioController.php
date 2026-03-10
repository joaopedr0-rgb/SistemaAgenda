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
        return view('usuarios.index', compact('usuarios')); 
    }

    /*
     * SINTAXE: public function create()
     * SEMÂNTICA: Método GET. Entrega a página de formulário em branco para cadastrar novos usuários.
     */
    public function create()
    {
        /*
         * SINTAXE: return view('caminho')
         * SEMÂNTICA: Apenas carrega o HTML com o formulário de cadastro.
         */
        return view('usuarios.create'); 
    }

    /*
     * SINTAXE: public function store(Request $request)
     * SEMÂNTICA: Método POST. Recebe os dados do formulário preenchido e tenta inseri-los no banco.
     */
    public function store(Request $request)
    {
        /*
         * SINTAXE: $request->validate([ regras ])
         * SEMÂNTICA: Protege a aplicação. Garante que campos obrigatórios existam, que o email seja válido e único, 
         * e que a senha tenha no mínimo 8 caracteres e seja confirmada.
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
             * SEMÂNTICA: Criptografa a senha usando o algoritmo Bcrypt antes de salvar no banco de dados.
             */
            'password' => Hash::make($dados['password']),
            
            /*
             * SINTAXE: 'coluna' => boolean
             * SEMÂNTICA: Força explicitamente que o usuário criado por esta rota será uma recepcionista (is_admin = false).
             */
            'is_admin' => false, 
        ]);

        /*
         * SINTAXE: redirect()->route('nome')->with('chave', 'mensagem')
         * SEMÂNTICA: Após criar, redireciona o usuário para a lista (index) com uma mensagem Flash de sucesso.
         */
        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

    /*
     * SINTAXE: public function edit(User $usuarios)
     * SEMÂNTICA: Route Model Binding. Busca o usuário pela URL. O parâmetro se chama $usuarios para agradar 
     * a rota padrão do Laravel (usuarios/{usuarios}), evitando o erro "Missing required parameter".
     */
    public function edit(User $usuarios)
    {
        /*
         * SINTAXE: return view('view', ['chave' => $variavel])
         * SEMÂNTICA: Renderiza o formulário de edição. Passamos a variável $usuarios para a view usando 
         * o nome 'user', assim o nosso HTML (que usa $user->name) funciona perfeitamente.
         */
        return view('usuarios.edit', ['user' => $usuarios]);
    }

    /*
     * SINTAXE: public function update(Request $request, User $usuarios)
     * SEMÂNTICA: Método PUT/PATCH. Recebe os novos dados ($request) e o usuário alvo no banco ($usuarios).
     */
    public function update(Request $request, User $usuarios)
    {
        /*
         * SINTAXE: $request->validate([ regras ])
         * SEMÂNTICA: Valida os dados da edição. A regra unique do e-mail tem um detalhe importante: 
         * 'unique:users,email,' . $usuarios->id ignora o ID do próprio usuário, permitindo que ele salve
         * sem alterar o e-mail, sem gerar erro de "e-mail já em uso". A senha agora é 'nullable' (opcional).
         */
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $usuarios->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], 
        ]);

        // Atualiza as propriedades em memória
        $usuarios->name = $dados['name'];
        $usuarios->email = $dados['email'];

        /*
         * SINTAXE: if (!empty($variavel))
         * SEMÂNTICA: Verifica se o campo senha foi preenchido. Se sim, criptografa a nova senha e atualiza. 
         * Se deixado em branco, a senha antiga é mantida.
         */
        if (!empty($dados['password'])) {
            $usuarios->password = Hash::make($dados['password']);
        }

        /*
         * SINTAXE: $objeto->save()
         * SEMÂNTICA: Dispara o "UPDATE" no banco de dados apenas com os campos que foram alterados em memória.
         */
        $usuarios->save();
        
        /*
         * SINTAXE/SEMÂNTICA: Redireciona de volta para a lista com mensagem de sucesso.
         */
        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
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

        /*
         * SINTAXE/SEMÂNTICA: Redireciona para o index passando a confirmação de que a recepcionista foi removida.
         */
        return redirect()->route('usuarios.index')->with('success', 'Recepcionista excluída com sucesso!');
    }
}