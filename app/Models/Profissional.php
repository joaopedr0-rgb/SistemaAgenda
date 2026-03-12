<?php

/*
 * SINTAXE: namespace
 * SEMÂNTICA: Define o endereço lógico do arquivo dentro do projeto (pasta App/Models), 
 * permitindo que o framework o carregue automaticamente sem precisarmos de 'require'.
 */
namespace App\Models;

// SINTAXE: use
// SEMÂNTICA: Importa a Trait 'HasFactory' (para gerar dados falsos de teste) e a superclasse 'Model' (o coração do Eloquent ORM).
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
 * SINTAXE: class NOME extends Model
 * SEMÂNTICA: Declara a classe Profissional, herdando todo o poder do ORM do Laravel 
 * (o que nos permite usar métodos como Profissional::all(), Profissional::find(), etc. lá nos Controllers).
 */
class Profissional extends Model
{
    /*
     * SINTAXE: use Trait;
     * SEMÂNTICA: Injeta as habilidades de fábrica de dados para podermos rodar seeders rapidamente no terminal.
     */
    use HasFactory;

    /*
     * SINTAXE: protected $table = "string";
     * SEMÂNTICA: 🏆 EXCELENTE USO AQUI! O Laravel tenta adivinhar o nome da tabela no banco sempre 
     * pluralizando o nome do Model pelas regras do inglês (adicionando um "s" no final). 
     * Se você não colocasse essa linha, o Laravel procuraria uma tabela chamada 'professionals' 
     * ou 'profissionals' e o sistema daria erro. Com essa linha, você sobrescreve a configuração 
     * padrão e força o Eloquent a usar a tabela 'profissionais'. Essa é a regra de ouro para projetos em PT-BR!
     */
    protected $table = "profissionais";
    
    /*
     * SINTAXE: protected $fillable = [ array ];
     * SEMÂNTICA: Proteção contra "Mass Assignment". Autoriza explicitamente o Laravel a salvar apenas 
     * essas 5 colunas quando usamos o comando 'Profissional::create($request->all())' lá no Controller. 
     * Ignora qualquer campo extra que um usuário mal-intencionado possa injetar pelo formulário HTML.
     */
    protected $fillable = [
        'nome',
        'CPF',
        'email',
        'funcao',
        'status',
    ];
}