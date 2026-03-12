<?php

/*
 * SINTAXE: namespace
 * SEMÂNTICA: Define a localização lógica do arquivo dentro do projeto (pasta App/Models).
 */
namespace App\Models;

// SINTAXE: use
// SEMÂNTICA: Importa a Trait para geração de dados falsos (HasFactory) e a classe base do ORM do Laravel (Model).
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
 * SINTAXE: class NOME extends PAI
 * SEMÂNTICA: Define a classe Cliente. Ao estender 'Model', o Laravel assume magicamente que 
 * existe uma tabela chamada 'clientes' (plural e minúsculo) no seu banco de dados.
 * * 💡 DICA DE ESTUDO: Como vimos no arquivo passado que um 'Agendamento' pertence a um 'Cliente', 
 * o ideal seria ter uma função aqui dentro chamada 'agendamentos()' retornando '$this->hasMany(Agendamento::class)'. 
 * Isso permitiria que você buscasse todos os agendamentos de um cliente de uma vez só usando '$cliente->agendamentos'.
 */
class Cliente extends Model
{
    /*
     * SINTAXE: use Trait;
     * SEMÂNTICA: Habilita o uso de Factories. Se você criar uma ClienteFactory, poderá popular 
     * a tabela 'clientes' com nomes e e-mails fictícios usando um único comando no terminal.
     */
    use HasFactory;
   
   /*
    * SINTAXE: protected $fillable = [ array ];
    * SEMÂNTICA: A famosa "Lista Branca" de proteção contra Mass Assignment. 
    * Informa ao Laravel que, quando o 'ClientesController' mandar salvar os dados do formulário 
    * usando 'Cliente::create($request->all())', APENAS as colunas 'nome', 'email', 'telefone' e 'status' 
    * têm permissão para serem preenchidas diretamente. Qualquer outro campo injetado na requisição será ignorado.
    */
   protected $fillable = ['nome','email','telefone','status',];
}