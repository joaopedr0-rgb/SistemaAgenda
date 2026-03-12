<?php

/*
 * SINTAXE: use
 * SEMÂNTICA: Importa as classes necessárias do framework para manipular o esquema do banco de dados.
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * SINTAXE: return new class extends Migration
 * SEMÂNTICA: Define uma migração anônima. É o padrão do Laravel para criar tabelas de forma organizada e versionada.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
     * SINTAXE: public function up()
     * SEMÂNTICA: Método executado ao rodar 'php artisan migrate'. Cria a estrutura necessária no banco.
     */
    public function up(): void
    {
        /*
         * SINTAXE: Schema::create('nome_da_tabela', function...)
         * SEMÂNTICA: Cria a tabela 'password_reset_tokens', usada pelo sistema nativo de recuperação de senha do Laravel.
         */
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            
            /*
             * SINTAXE: $table->string('email')->primary();
             * SEMÂNTICA: Define a coluna 'email' como Chave Primária (Primary Key). 
             * Isso significa que o banco não permite IDs repetidos e usa o e-mail como identificador principal desta tabela.
             */
            $table->string('email')->primary();
            
            /*
             * SINTAXE: $table->string('token');
             * SEMÂNTICA: Armazena o código alfanumérico aleatório enviado por e-mail ao usuário para validar a troca da senha.
             */
            $table->string('token');
            
            /*
             * SINTAXE: $table->timestamp('created_at')->nullable();
             * SEMÂNTICA: Registra quando o token foi gerado. O Laravel usa isso para expirar tokens antigos (ex: após 60 minutos).
             */
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    /*
     * SINTAXE: public function down()
     * SEMÂNTICA: Método de "Rollback". Exclui a tabela caso você precise reverter a migração.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};