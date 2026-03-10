<?php

/*
 * SINTAXE: use
 * SEMÂNTICA: Importa as classes do Schema Builder do Laravel, que transformam comandos PHP em comandos SQL (CREATE TABLE).
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * SINTAXE: return new class extends Migration
 * SEMÂNTICA: Define a estrutura da tabela 'profissionais'. Migrations são o "histórico" do seu banco de dados.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
     * SINTAXE: public function up()
     * SEMÂNTICA: Este método cria a tabela. Quando você rodar 'php artisan migrate', o Laravel executará o código abaixo.
     */
    public function up(): void
    {
        /*
         * SINTAXE: Schema::create('profissionais', ...)
         * SEMÂNTICA: Cria a tabela física no banco. O nome 'profissionais' é importante para manter a consistência com o restante do sistema.
         */
        Schema::create('profissionais', function (Blueprint $table) {
            
            // SINTAXE: $table->id();
            // SEMÂNTICA: Cria a chave primária autoincrementável. Cada profissional terá um número único (1, 2, 3...).
            $table->id();
            
            // SINTAXE: $table->string('nome');
            // SEMÂNTICA: Coluna de texto para o nome completo.
            $table->string('nome');
            
            /*
             * SINTAXE: ->unique()
             * SEMÂNTICA: Regra de Ouro. O CPF não pode se repetir no banco de dados. 
             * Se tentarem cadastrar o mesmo CPF duas vezes, o próprio banco de dados travará a operação.
             */
            $table->string('CPF')->unique();
            
            /*
             * SINTAXE: ->unique()
             * SEMÂNTICA: O mesmo vale para o e-mail. Garante que cada profissional tenha um acesso exclusivo.
             */
            $table->string('email')->unique();
            
            // SINTAXE: $table->string('funcao');
            // SEMÂNTICA: Armazena o cargo (ex: "Barbeiro", "Manicure", "Esteticista").
            $table->string('funcao');
            
            /*
             * SINTAXE: ->default('ativo')
             * SEMÂNTICA: Praticidade. Se você não informar o status no formulário, 
             * o banco já grava como 'ativo' automaticamente.
             */
            $table->string('status')->default('ativo');
            
            /*
             * SINTAXE: $table->timestamps();
             * SEMÂNTICA: Cria as colunas 'created_at' e 'updated_at' para controle de auditoria.
             */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    /*
     * SINTAXE: public function down()
     * SEMÂNTICA: O "Z desfazer". Se você rodar 'php artisan migrate:rollback', esta tabela será apagada do banco.
     */
    public function down(): void
    {
        Schema::dropIfExists('profissionais');
    }
};