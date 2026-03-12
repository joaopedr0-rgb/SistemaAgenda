<?php

/*
 * SINTAXE: use
 * SEMÂNTICA: Importa as ferramentas de construção de banco de dados do Laravel (Migration, Blueprint, Schema).
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * SINTAXE: return new class extends Migration
 * SEMÂNTICA: Define a migração para a tabela do Laravel Sanctum. Esta tabela armazena os tokens de acesso pessoal.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
     * SINTAXE: public function up()
     * SEMÂNTICA: Método que cria a tabela no banco de dados quando rodamos 'php artisan migrate'.
     */
    public function up(): void
    {
        /*
         * SINTAXE: Schema::create('personal_access_tokens', ...)
         * SEMÂNTICA: Cria a tabela física onde ficam guardados os "crachás digitais" (tokens) dos usuários.
         */
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            
            // SINTAXE: $table->id();
            // SEMÂNTICA: Chave primária única para identificar cada registro de token.
            $table->id();

            /*
             * SINTAXE: $table->morphs('tokenable');
             * SEMÂNTICA: 🏆 CONCEITO AVANÇADO (Polimorfismo). 
             * Este comando cria duas colunas automaticamente: 'tokenable_type' e 'tokenable_id'.
             * Isso permite que o token seja associado a QUALQUER model (ex: User, Admin ou Profissional), 
             * tornando o sistema de autenticação muito flexível.
             */
            $table->morphs('tokenable');

            /*
             * SINTAXE: $table->string('name');
             * SEMÂNTICA: Um nome amigável para o token (ex: "Celular do João" ou "Integração Desktop").
             */
            $table->string('name');

            /*
             * SINTAXE: $table->string('token', 64)->unique();
             * SEMÂNTICA: O código secreto em si. O Laravel limita a 64 caracteres e exige que seja 
             * único no banco para garantir que dois usuários não tenham o mesmo "segredo".
             */
            $table->string('token', 64)->unique();

            /*
             * SINTAXE: $table->text('abilities')->nullable();
             * SEMÂNTICA: Define as permissões (scopes) do token. 
             * Ex: ["create-post", "delete-post"]. Se for nulo, o token pode ter permissões padrão.
             */
            $table->text('abilities')->nullable();

            /*
             * SINTAXE: $table->timestamp('last_used_at')->nullable();
             * SEMÂNTICA: Registra a última vez que o usuário fez uma requisição usando este token. 
             * Ótimo para saber se um aparelho está inativo.
             */
            $table->timestamp('last_used_at')->nullable();

            /*
             * SINTAXE: $table->timestamp('expires_at')->nullable();
             * SEMÂNTICA: Define uma data de validade. Após esse horário, o token para de funcionar.
             */
            $table->timestamp('expires_at')->nullable();

            /*
             * SINTAXE: $table->timestamps();
             * SEMÂNTICA: Cria 'created_at' e 'updated_at' para controle de auditoria do token.
             */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    /*
     * SINTAXE: public function down()
     * SEMÂNTICA: Remove a tabela de tokens caso a migração precise ser revertida.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};