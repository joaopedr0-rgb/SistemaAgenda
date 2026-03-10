<?php

/*
 * SINTAXE: use
 * SEMÂNTICA: Importa as ferramentas necessárias do Laravel para desenhar a estrutura da tabela no banco.
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * SINTAXE: return new class extends Migration
 * SEMÂNTICA: Cria uma migração anônima que descreve a tabela 'clientes'.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
     * SINTAXE: public function up()
     * SEMÂNTICA: Método que "sobe" a tabela para o banco. Define as colunas e regras de cada dado do cliente.
     */
    public function up(): void
    {
        /*
         * SINTAXE: Schema::create('clientes', ...)
         * SEMÂNTICA: Cria a tabela física 'clientes'. Note que o nome está em português e no plural, 
         * o que bate perfeitamente com o seu Model 'Cliente' (que usa o padrão de busca automática).
         */
        Schema::create('clientes', function (Blueprint $table) {
            
            // SINTAXE: $table->id();
            // SEMÂNTICA: Cria a chave primária. Essencial para que os Agendamentos saibam exatamente qual cliente é o dono do horário.
            $table->id();
            
            // SINTAXE: $table->string('nome');
            // SEMÂNTICA: Cria um campo VARCHAR(255) para o nome completo do cliente.
            $table->string('nome');
            
            /*
             * SINTAXE: ->unique()
             * SEMÂNTICA: Regra de Integridade. Garante que o sistema não permita cadastrar dois clientes 
             * com o mesmo e-mail, evitando duplicidade de registros.
             */
            $table->string('email')->unique();
            
            /*
             * SINTAXE: ->nullable()
             * SEMÂNTICA: Define que o telefone não é obrigatório. 
             * Se o cliente não tiver ou não quiser informar, o banco aceitará o valor NULL.
             */
            $table->string('telefone')->nullable();
            
            /*
             * SINTAXE: ->default('ativo')
             * SEMÂNTICA: Valor Padrão. Se você não especificar o status na hora de salvar, 
             * o Laravel automaticamente gravará 'ativo' no banco. Ótimo para gestão de cadastros.
             */
            $table->string ('status')->default('ativo');
            
            /*
             * SINTAXE: $table->timestamps();
             * SEMÂNTICA: Cria 'created_at' e 'updated_at'. 
             * Permite que você saiba exatamente quando o cliente se cadastrou na sua clínica/loja.
             */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    /*
     * SINTAXE: public function down()
     * SEMÂNTICA: Deleta a tabela de clientes caso você precise desfazer a migração (rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};