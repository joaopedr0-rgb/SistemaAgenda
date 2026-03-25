<?php

/*
SINTAXE: 'namespace' define o caminho lógico da classe.
SEMÂNTICA: Localiza o arquivo dentro da estrutura de pastas do Laravel (Controllers), seguindo as normas de carregamento automático de classes (Autoload).
*/
namespace App\Http\Controllers;

/*
SINTAXE: Importação da classe base Request.
SEMÂNTICA: Permite capturar dados de entrada (filtros, formulários) caso você queira expandir a busca financeira no futuro.
*/
use Illuminate\Http\Request;
use App\Models\Agendamento; // Importação recomendada para facilitar a leitura

class CobrancaController extends Controller
{
    /* SINTAXE: 'public function index()' - Método público sem parâmetros obrigatórios.
    SEMÂNTICA: É o ponto de entrada da tela financeira. Sua função é processar o "Fechamento de Caixa", calculando o que entrou e o que deve ser pago aos profissionais.
    */
    public function index()
    {
        /* SINTAXE: Model::with([...])->get();
        SEMÂNTICA: Carregamento Antecipado (Eager Loading). Buscamos TODOS os agendamentos trazendo junto os nomes dos clientes e serviços para popular a tabela da View.
        */
        $agendamentos = Agendamento::with(['cliente', 'servico'])->get();

        /* SINTAXE: $colecao->where('coluna', 'valor')->sum(callback);
        SEMÂNTICA: Cálculo do TOTAL RECEBIDO. Filtra apenas os serviços com status 'concluido' e soma seus preços. Representa o dinheiro que já está no caixa.
        */
        $totalRecebido = $agendamentos->where('status', 'concluido')->sum(fn($a) => $a->servico->preco ?? 0);

        /*
        /*
        SINTAXE: Filtro duplo (status e data >= hoje).
        SEMÂNTICA: Cálculo do TOTAL PENDENTE. Identifica serviços que ainda não aconteceram ou estão agendados para hoje. É o dinheiro "garantido" que ainda vai entrar no caixa.
        */
        $totalPendente = $agendamentos->where('status', 'pendente')
                                        ->where('data', '>=', date('Y-m-d'))
                                        ->sum(fn($a) => $a->servico->preco ?? 0);
        
                                        /*
        /*
        SINTAXE: Filtro duplo (status e data < hoje).
        SEMÂNTICA: Cálculo do TOTAL EM ATRASO. Essa é a inteligência do sistema: se um serviço ficou como 'pendente' e a data já passou, ele entra automaticamente nesta soma. Ajuda o dono do salão a identificar clientes inadimplentes.
        */
        $totalAtrasado = $agendamentos->where('status', 'pendente')
                                        ->where('data', '<', date('Y-m-d'))
                                        ->sum(fn($a) => $a->servico->preco ?? 0);

        /*
        SINTAXE: 'return view(caminho, compact(...))'.
        SEMÂNTICA: Envia a lista completa de agendamentos e os 3 novos totais calculados para a View. Agora, os Cards coloridos que o seu colega criou exibirão valores reais vindos do banco.
        */
        return view('cobrancas.index', compact('agendamentos', 'totalRecebido', 'totalPendente', 'totalAtrasado'));
    }
}
