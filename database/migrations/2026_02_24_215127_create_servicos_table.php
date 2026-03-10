<?php

/*
 * SINTAXE: use
 * SEMÂNTICA: Importa as classes do Schema Builder do Laravel para converter código PHP em comandos SQL de criação de tabela.
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * SINTAXE: return new class extends Migration
 * SEMÂNTICA: Define a migração para a tabela 'servicos'. O Laravel usará isso para estruturar o catálogo de itens oferecidos pela clínica/loja.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
     * SINTAXE: public function up()
     * SEMÂNTICA: Método que cria a tabela no banco de dados.
     */
    public function up(): void
    {
        /*
         * SINTAXE: Schema::create('servicos', ...)
         * SEMÂNTICA: Cria a tabela física. Note que o nome 'servicos' (sem acento) é a prática padrão para evitar problemas de codificação em bancos de dados.
         */
        Schema::create('servicos', function (Blueprint $table) {
            
            // SINTAXE: $table->id();
            // SEMÂNTICA: Chave primária. Cada serviço terá um ID único para ser referenciado nos agendamentos.
            $table->id();
            
            // SINTAXE: $table->string('nome');
            // SEMÂNTICA: Nome do serviço (ex: "Corte Social", "Manicure completa").
            $table->string('nome');
            
            /*
             * SINTAXE: $table->decimal('preco', 8, 2);
             * SEMÂNTICA: 🏆 EXCELENTE ESCOLHA TÉCNICA! O tipo 'decimal' garante precisão matemática para valores monetários.
             * O '8' significa que o número pode ter até 8 dígitos no total.
             * O '2' significa que 2 desses dígitos são para as casas decimais (centavos). 
             * Exemplo: Pode armazenar até R$ 999.999,99.
             */
            $table->decimal('preco', 8, 2);
            
            /*
             * SINTAXE: $table->integer('duracao');
             * SEMÂNTICA: Armazena o tempo estimado. Geralmente interpretado em minutos (ex: 30, 60, 120).
             */
            $table->integer('duracao');
            
            /*
             * SINTAXE: ->default('ativo')
             * SEMÂNTICA: Garante que todo novo serviço cadastrado comece como disponível para uso no sistema.
             */
            $table->string('status')->default('ativo');
            
            // SINTAXE: $table->string('descricao');
            // SEMÂNTICA: Campo de texto para detalhes adicionais do serviço.
            $table->string('descricao');
            
            /*
             * SINTAXE: $table->timestamps();
             * SEMÂNTICA: Registra automaticamente data de criação e última atualização do serviço.
             */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    /*
     * SINTAXE: public function down()
     * SEMÂNTICA: Remove a tabela 'servicos' caso o comando 'migrate:rollback' seja executado.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};