<?php

/*
 * SINTAXE: use
 * SEMÂNTICA: Importa as ferramentas necessárias para construir o esquema do banco de dados (Schema e Blueprint).
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * SINTAXE: return new class extends Migration
 * SEMÂNTICA: Define uma classe anônima de migração. É o padrão moderno do Laravel para evitar conflitos de nomes de classes em projetos grandes.
 */
return new class extends Migration {
    /**
     * Run the migrations.
     */
    /*
     * SINTAXE: public function up()
     * SEMÂNTICA: Este método é executado quando você roda 'php artisan migrate'. 
     * Ele contém as instruções para CRIAR ou ALTERAR algo no banco de dados.
     */
    public function up(): void
    {
        /*
         * SINTAXE: Schema::create('nome_da_tabela', function...)
         * SEMÂNTICA: Comando para criar a tabela física chamada 'users' no seu SQL (MySQL, PostgreSQL, etc).
         */
        Schema::create('users', function (Blueprint $table) {

            // SINTAXE: $table->id();
            // SEMÂNTICA: Cria uma coluna 'id' do tipo BIGINT, Autoincremento e Chave Primária.
            $table->id();

            // SINTAXE: $table->string('coluna');
            // SEMÂNTICA: Cria uma coluna do tipo VARCHAR(255). Ideal para nomes e e-mails.
            $table->string('name');

            // SINTAXE: ->unique()
            // SEMÂNTICA: Índice de restrição. Impede que o banco aceite dois cadastros com o mesmo e-mail.
            $table->string('email')->unique();

            // SINTAXE: ->nullable()
            // SEMÂNTICA: Permite que esta coluna fique vazia (NULL) no banco de dados até que o e-mail seja verificado.
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            /*
             * SINTAXE: $table->boolean('coluna')->default(false);
             * SEMÂNTICA: Cria uma coluna de verdadeiro/falso. O 'default(false)' garante que, 
             * se você não avisar nada no cadastro, o novo usuário nascerá como "cliente/recepcionista" e não como Admin.
             */
            $table->boolean('is_admin')->default(false);

            // SINTAXE: $table->rememberToken();
            // SEMÂNTICA: Cria uma coluna especial para armazenar o token da função "Lembrar-me" do login.
            $table->rememberToken();

            /*
             * SINTAXE: $table->timestamps();
             * SEMÂNTICA: Comando "dois em um". Cria as colunas 'created_at' (data de criação) 
             * e 'updated_at' (data da última edição). O Laravel preenche elas sozinho!
             */
            $table->timestamps();
            $table->string('cep', 8)->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 2)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable(); // Campo manual, a API não traz o número da casa
        });
    }

    /**
     * Reverse the migrations.
     */
    /*
     * SINTAXE: public function down()
     * SEMÂNTICA: Este método é o "Botão de Desfazer". Ele é executado quando você roda 'php artisan migrate:rollback'.
     */
    public function down(): void
    {
        /*
         * SINTAXE: Schema::dropIfExists('users');
         * SEMÂNTICA: Deleta a tabela 'users' e todos os seus dados permanentemente. Use com cautela!
         */
        Schema::dropIfExists('users');
    }
};