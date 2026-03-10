<?php

/*
 * SINTAXE: namespace
 * SEMÂNTICA: Define o endereço lógico do arquivo (App\Models). Isso permite que o Laravel 
 * localize esta classe automaticamente através do Autoload do PHP (PSR-4).
 */
namespace App\Models;

// SINTAXE: use
// SEMÂNTICA: Importa a Trait 'HasFactory' para testes automatizados e a classe 'Model' que fornece todo o poder do Eloquent ORM.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
 * SINTAXE: class NOME extends Model
 * SEMÂNTICA: Define a classe Servico. Por convenção, o Laravel associará este Model 
 * à tabela 'servicos' (plural em português, mas o Laravel tentará 'servicos' ou 'servicos' dependendo da versão).
 * Dica: Se a tabela no banco se chamar "servicos", o Laravel geralmente identifica, mas você 
 * poderia usar o "protected $table = 'servicos';" se desse erro de pluralização.
 */
class Servico extends Model
{
    /*
     * SINTAXE: use Trait;
     * SEMÂNTICA: Permite criar fábricas de dados (Factories) para gerar vários serviços 
     * fictícios de uma vez no banco de dados durante a fase de desenvolvimento.
     */
    use HasFactory;

    /*
     * SINTAXE: protected $fillable = [ array ];
     * SEMÂNTICA: Define a "Lista Branca" de campos que podem ser preenchidos via atribuição em massa. 
     * É a proteção essencial que impede que campos sensíveis sejam alterados por usuários mal-intencionados 
     * através de requisições HTTP forjadas.
     */
    protected $fillable = [
        'nome',      // Nome do serviço (ex: Limpeza de Pele)
        'preco',     // Valor monetário do serviço
        'duracao',   // Tempo estimado do serviço (ex: 00:30 ou 30)
        'status',    // Se o serviço está ativo ou inativo
        'descricao', // Detalhes sobre o que o serviço inclui
    ];
}