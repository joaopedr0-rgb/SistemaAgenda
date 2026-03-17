<?php

/*
 * SINTAXE: namespace
 * SEMÂNTICA: Define o endereço lógico da classe. Todos os seus Models (tabelas do banco) moram no diretório App\Models.
 */
namespace App\Models;

// SINTAXE: use
// SEMÂNTICA: Importa a "Trait" HasFactory (usada para criar dados falsos para testes) e a classe principal 'Model' do Eloquent.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
 * SINTAXE: class Nome extends Model
 * SEMÂNTICA: A Mágica do Eloquent! Ao herdar de 'Model', o Laravel assume automaticamente 
 * que esta classe representa uma tabela chamada 'agendamentos' (ele pega o nome 'Agendamento', 
 * passa para minúsculo e pluraliza em inglês/português básico) no seu banco de dados MySQL/PostgreSQL.
 */
class Agendamento extends Model
{
    /*
     * SINTAXE: use Trait;
     * SEMÂNTICA: Injeta a capacidade de usar "Factories". Permite rodar comandos como 'Agendamento::factory()->count(10)->create()' 
     * para encher seu banco com 10 agendamentos de teste rapidamente.
     */
    use HasFactory;

    // CORREÇÃO 1: Mudamos 'funcionario_id' para 'profissional_id'
    /*
     * SINTAXE: protected $fillable = [ array_de_strings ]
     * SEMÂNTICA: Proteção contra vulnerabilidade de "Mass Assignment" (Atribuição em Massa). 
     * Esta variável diz ao Laravel: "Quando o Controller mandar um $request->all(), SÓ PERMITA 
     * que essas quatro colunas exatas sejam preenchidas e salvas no banco. Se um hacker tentar 
     * injetar um campo 'id' ou 'is_admin' maliciosamente no formulário HTML, ignore-os completamente".
     */
    protected $fillable = [
        'cliente_id',
        'servico_id',
        'profissional_id',
        'data',
        'hora',
    ];

    // CORREÇÃO 2: Tiramos as aspas simples de dentro dos parênteses
    /*
     * SINTAXE: public function nomeDaTabelaNoSingular()
     * SEMÂNTICA: Define o Relacionamento no banco de dados. Como um agendamento é feito para UM cliente, o nome da função fica no singular.
     */
    public function cliente()
    {
        /*
         * SINTAXE: return $this->belongsTo(Classe::class);
         * SEMÂNTICA: "Belongs To" significa "Pertence A". 
         * O Laravel é inteligente: ele lê essa linha e entende "Ok, a tabela 'agendamentos' 
         * tem uma coluna chamada 'cliente_id'. Vou pegar esse número, ir lá na tabela 'clientes' 
         * e buscar o cliente que tem esse 'id'". 
         * É assim que você consegue usar `$agendamento->cliente->nome` lá no seu arquivo Blade!
         */
        return $this->belongsTo(Cliente::class);
    }

    /*
     * SINTAXE: public function profissional()
     * SEMÂNTICA: Exatamente a mesma lógica acima. Define que este agendamento está atrelado a UM profissional específico.
     */
    public function profissional()
    {
        /*
         * SINTAXE: $this->belongsTo()
         * SEMÂNTICA: Liga a coluna 'profissional_id' desta tabela com a chave primária 'id' da tabela de profissionais.
         */
        return $this->belongsTo(Profissional::class);
    }
    public function servico()
    {
        // Indica que o Agendamento pertence a um Serviço
        return $this->belongsTo(Servico::class, 'servico_id');
    }

    // CORREÇÃO 3: Apaguei a função agendamento() que estava sobrando aqui.
    // (Nota de estudo: Excelente correção! Um Agendamento não precisa ter uma relação "pertence a" com ele mesmo nesse contexto, deletar foi a decisão correta).
}