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

class CobrancaController extends Controller
{
    /* SINTAXE: 'public function index()' - Método público sem parâmetros obrigatórios.
    SEMÂNTICA: É o ponto de entrada da tela financeira. Sua função é processar o "Fechamento de Caixa", calculando o que entrou e o que deve ser pago aos profissionais.
    */
    public function index()
    {
        /*
        SINTAXE: Model::where('coluna', 'valor')->with([...])->get();
        SEMÂNTICA: Filtro de Negócio. Buscamos apenas os agendamentos com status 'concluido', pois um serviço "pendente" ainda não gera faturamento real. 
        O 'with' carrega o Serviço e o Profissional de uma vez, evitando consultas repetitivas ao banco (Problema N+1).
        */
        $agendamentos = \App\Models\Agendamento::where('status', 'concluido')->with(['servico', 'profissional'])->get();

       /*
        SINTAXE: '$agendamentos->sum(callback)'.
        SEMÂNTICA: Cálculo do Faturamento Bruto. O método sum() percorre a coleção de agendamentos e soma o preço de cada serviço. 
        O operador '?? 0' é uma segurança: se um serviço foi removido do banco, o sistema assume 0 e não trava o cálculo.
        */
        $faturamentoTotal = $agendamentos->sum(function($a) {
            return $a->servico->preco ?? 0;
        });

        /*
        SINTAXE: '$agendamentos->sum('coluna')'.
        SEMÂNTICA: Soma das Comissões. Aqui somamos diretamente a coluna 'valor_comissao_pago' que você salvou no banco quando o serviço foi finalizado. Isso representa o "custo" de mão de obra do salão.
        */
        $totalComissoes = $agendamentos->sum('valor_comissao_pago');

        /*
        SINTAXE: Subtração simples de variáveis.
        SEMÂNTICA: Lucro Líquido. Representa o que sobra para o salão após o pagamento das porcentagens dos profissionais (Faturamento - Comissões).
        */
        $lucroSalao = $faturamentoTotal - $totalComissoes;

        /*
        SINTAXE: 'return view(caminho, compact)'.
        SEMÂNTICA: Renderiza a tela 'resources/views/cobrancas/index.blade.php' e injeta nela os quatro resultados calculados para que o HTML possa exibi-los nos "Cards" coloridos.
        */
        return view('cobrancas.index', compact('agendamentos', 'faturamentoTotal', 'totalComissoes', 'lucroSalao'));
    }
}
