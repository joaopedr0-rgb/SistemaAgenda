<?php
/*
SINTAXE: A tag <?php indica ao servidor web que o código a seguir deve ser interpretado como PHP.
SEMÂNTICA: Abertura padrão de arquivo PHP. Como o arquivo só contém PHP, a tag de fechamento (?>) é omitida intencionalmente para evitar espaços em branco acidentais na saída.
route

/*
SINTAXE: 'namespace' é usado para agrupar classes e evitar conflitos de nomes.
SEMÂNTICA: No ecossistema Laravel, o namespace reflete a estrutura de pastas físicas (App/Http/Controllers), seguindo o padrão PSR-4 de autoload.
*/
namespace App\Http\Controllers;

/*
SINTAXE: 'use' importa as classes especificadas para dentro do escopo deste arquivo.
SEMÂNTICA: Importamos os 3 Models necessários. Como estamos na tela de agendamento, 
precisamos listar os Clientes e os Profissionais nos campos de "Select" da interface, 
além de manipular o próprio model Agendamento.
*/
use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Servico;

/*
SINTAXE: Importa a classe Request do componente HTTP do framework (Illuminte).
SEMÂNTICA: Essa classe lida com todos os dados da requisição HTTP (inputs de formulários, arquivos, cabeçalhos, etc).
*/
use Illuminate\Http\Request;

/*
SINTAXE: 'class' declara uma nova classe. 'extends' indica herança.
SEMÂNTICA: Criamos a classe AgendamentosController que herda de Controller (classe base do Laravel que gerencia middlewares, validações e autorizações básicas).
*/
class AgendamentosController extends Controller
{
    /*
    SINTAXE: 'public' define a visibilidade do método (acessível de fora da classe). 'function' declara o método.
    SEMÂNTICA: O método index() no padrão RESTful/CRUD é sempre o responsável por listar os registros (mostrar a tabela).
    */
    public function index()
    {
        /*
        SINTAXE: '$' indica uma variável. '::' é o Operador de Resolução de Escopo (chama métodos estáticos de uma classe).
        SEMÂNTICA: Carrega todos os dados do banco para enviar à tabela de listagem.
        O método all() do Eloquent ORM traduz-se em um "SELECT * FROM tabela" nos bastidores 
        e retorna uma 'Collection' (um super-array do Laravel com métodos extras).
        */
        $agendamentos = Agendamento::all();
        $clientes = Cliente::all();
        $profissionais = Profissional::all();
        $servicos = Servico::all();

        /*
        SINTAXE: return devolve um resultado da função. view() é uma função global (helper).
        SEMÂNTICA: A função view('pasta.arquivo') localiza o arquivo resources/views/agendamentos/index.blade.php.
        
        SINTAXE: compact('var1', 'var2', 'var3') é uma função nativa do PHP.
        SEMÂNTICA: O compact pega as variáveis locais (cujos nomes passamos como strings) 
        e as empacota em um array associativo ['agendamentos' => $agendamentos, ...] 
        para injetá-las na View, permitindo que o HTML as utilize.
        */
        return view('agendamentos.index', compact('agendamentos', 'clientes', 'profissionais'));
    }

    /*
    SINTAXE: Método público. Sem parâmetros de entrada.
    SEMÂNTICA: O método create() é responsável por exibir o formulário HTML em branco para a criação de um novo registro.
    */
    public function create()
    {
        /*
        SINTAXE: Declaração de variáveis buscando dados através do Eloquent (Model::all()).
        SEMÂNTICA: Na hora de criar um agendamento, o usuário precisa escolher quem é o cliente e 
        quem é o profissional via "dropdowns" (tags <select>). Por isso, buscamos essas listas no 
        banco de dados e mandamos para popular o formulário.
        */
        $clientes = Cliente::all();
        $profissionais = Profissional::all();
        $servicos = Servico::all();

        /*
        SINTAXE: Helper view() com função compact().
        SEMÂNTICA: Retorna a view resources/views/agendamentos/create.blade.php passando os dados para montar os selects.
        */
        return view('agendamentos.create', compact('clientes', 'profissionais'));
    }

    /*
    SINTAXE: 'Request $request' é Type-Hinting (dizendo que $request deve ser do tipo Request).
    SEMÂNTICA: Injeção de Dependência. O Laravel percebe que você precisa do objeto Request 
    e automaticamente o instancia e "injeta" aqui, trazendo todos os dados preenchidos no formulário.
    O método store() é responsável por salvar os dados no banco de dados.
    */
    public function store(Request $request)
    {
        /*
        SINTAXE: '$request->validate([...])'. O operador '->' acessa um método do objeto. O array `[]` passa as regras.
        SEMÂNTICA: Ao invés de usar $request->all(), o Laravel guarda dentro da variável $validated 
        APENAS os dados que passaram na validação especificada no array. É muito mais seguro e 
        evita ataques de atribuição em massa (Mass Assignment Vulnerability).
        */
        $validated = $request->validate([
            /*
            SINTAXE: Chave (nome do campo no formulário) => Valor (regras separadas por '|').
            SEMÂNTICA: 'required' = campo obrigatório. 'exists:tabela,coluna' = Regra de segurança fantástica. 
            Ele vai no banco de dados, na tabela 'clientes', e verifica se o 'id' existe lá.
            */
            'cliente_id'      => 'required|exists:clientes,id',
            
            /* SEMÂNTICA: ERRO CORRIGIDO (informação original): mudamos de 'funcionarios' para 'profissionais'.
            Mesma lógica de segurança acima, valida se o profissional escolhido é real. 
            Evita que alguém manipule o Inspecionar Elemento do HTML e mande um ID inexistente.
            */
            'profissional_id' => 'required|exists:profissionais,id', 
            
            'servico_id'      => 'required|exists:servicos,id',

            /*
            SINTAXE/SEMÂNTICA: 'date' verifica se o formato é uma data válida para o PHP/Banco.
            */
            'data'            => 'required|date',

            /*
            SINTAXE/SEMÂNTICA: 'date_format:H:i' obriga que a string recebida venha estritamente no formato Hora:Minuto (Ex: 14:30).
            */
            'hora'            => 'required|date_format:H:i',
        ]);
        
        /*
        SINTAXE: Model::create($array_de_dados).
        SEMÂNTICA: Cria o registro no banco de dados executando um "INSERT INTO" por baixo dos panos, 
        usando apenas os dados limpos e validados ($validated).
        *Nota: Para isso funcionar, o Model Agendamento deve ter a propriedade $fillable configurada.*
        */
        Agendamento::create($validated);

        /*
        SINTAXE: Encadeamento de métodos (Method Chaining): redirect()->route()->with().
        SEMÂNTICA: 
        1. redirect(): Inicia a resposta de redirecionamento.
        2. route('agendamentos.index'): Redireciona para a rota nomeada (corrigido para o padrão plural do resource).
        3. with('success', '...'): Cria uma "Flash Session" (sessão temporária) para exibir a mensagem verde de sucesso na tela de listagem.
        */
        return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado!');
    }

    /*
    SINTAXE: 'Agendamento $agendamento' como parâmetro.
    SEMÂNTICA: O método edit() mostra o formulário preenchido para edição.
    O Laravel usa uma mágica chamada "Route Model Binding": ele pega o ID que vem na URL (ex: /agendamentos/5/edit), 
    vai automaticamente no banco, faz um "SELECT * WHERE id = 5", e injeta o objeto inteiro na variável $agendamento.
    */
    public function edit(Agendamento $agendamento)
    {
        /*
        SINTAXE/SEMÂNTICA: Carregamos novamente as listas de Clientes e Profissionais para que os campos 
        'Select' do HTML possam ser renderizados, permitindo que o usuário escolha novas opções, se quiser.
        */
        $clientes = Cliente::all();
        $profissionais = Profissional::all();

        /*
        SINTAXE/SEMÂNTICA: Envia 3 variáveis para a view: o registro atual ($agendamento) e as listas preenchidas.
        */
        return view('agendamentos.edit', compact('agendamento', 'clientes', 'profissionais'));
    }

    /*
    SINTAXE: Recebe o Request (dados atualizados do form) e o Agendamento (registro atual do banco via Route Model Binding).
    SEMÂNTICA: O método update() recebe os dados novos e salva (atualiza) o registro no banco.
    */
    public function update(Request $request, Agendamento $agendamento)
    {
        /*
        SINTAXE/SEMÂNTICA: Repete as regras de validação do método store().
        É vital garantir que a edição também passe pelo mesmo rigor de segurança da criação (Required e Exists).
        */
        $validated = $request->validate([
            'cliente_id'      => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:profissionais,id', /* ERRO CORRIGIDO para 'profissionais' mantido */
            'servico_id'      => 'required|exists:servicos,id',
            'data'            => 'required|date',
            'hora'            => 'required|date_format:H:i',
        ]);

        /*
        SINTAXE: $objeto->update($array_validado).
        SEMÂNTICA: Ao invés de "::create", usamos o método "update()" direto na instância do model que 
        o Laravel buscou pra gente. Ele faz um "UPDATE tabela SET ... WHERE id = ?" com os dados seguros.
        */
        $agendamento->update($validated);

        /*
        SINTAXE/SEMÂNTICA: Igual ao store. Redireciona devolvendo para a lista e mandando a Flash Message de sucesso.
        */
        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado!');
    }

    /*
    SINTAXE: Parâmetro do tipo Model.
    SEMÂNTICA: O método destroy() exclui um registro. 
    Aproveitamos novamente o "Route Model Binding", onde o ID vindo da requisição HTTP DELETE 
    já é convertido no próprio registro do banco a ser excluído.
    */
    public function destroy(Agendamento $agendamento)
    {
        /*
        SINTAXE: $objeto->delete().
        SEMÂNTICA: Dispara o comando "DELETE FROM tabela WHERE id = ?" no banco de dados. 
        (Se você estiver usando SoftDeletes no Model, ele apenas preencherá a coluna deleted_at).
        */
        $agendamento->delete();
        
        /*
        SINTAXE/SEMÂNTICA: Redireciona para o index (agendamentos.index - padrão pluralizado) 
        passando a mensagem de confirmação de remoção.
        */
        return redirect()->route('agendamentos.index')->with('success', 'Agendamento removido!');
    }
}