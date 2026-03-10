<?php

/*
 * SINTAXE: use
 * SEMÂNTICA: Importa as ferramentas para manipulação do esquema do banco de dados (Migration, Blueprint, Schema).
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * SINTAXE: return new class extends Migration
 * SEMÂNTICA: Define uma migração anônima. Esta tabela específica serve para registrar falhas em filas (queues).
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
     * SINTAXE: public function up()
     * SEMÂNTICA: Cria a estrutura de dados necessária para o gerenciamento de erros do sistema de filas do Laravel.
     */
    public function up(): void
    {
        /*
         * SINTAXE: Schema::create('failed_jobs', ...)
         * SEMÂNTICA: Cria a tabela física onde o Laravel "estaciona" as tarefas que geraram exceções.
         */
        Schema::create('failed_jobs', function (Blueprint $table) {
            
            // SINTAXE: $table->id();
            // SEMÂNTICA: Chave primária autoincrementável para cada falha registrada.
            $table->id();

            /*
             * SINTAXE: $table->string('uuid')->unique();
             * SEMÂNTICA: Identificador único universal (UUID) para a tarefa. 
             * Garante que possamos rastrear a tarefa exata mesmo que ela mude de banco ou fila.
             */
            $table->string('uuid')->unique();

            /*
             * SINTAXE: $table->text('connection');
             * SEMÂNTICA: Registra qual driver estava sendo usado (ex: database, redis, sqs). 
             * Usa 'text' pois o nome da conexão pode ser longo.
             */
            $table->text('connection');

            // SINTAXE: $table->text('queue');
            // SEMÂNTICA: Registra em qual fila a tarefa estava (ex: 'default', 'emails', 'high-priority').
            $table->text('queue');

            /*
             * SINTAXE: $table->longText('payload');
             * SEMÂNTICA: Guarda todos os dados da tarefa (os objetos PHP serializados). 
             * Usa 'longText' para suportar grandes volumes de dados.
             */
            $table->longText('payload');

            /*
             * SINTAXE: $table->longText('exception');
             * SEMÂNTICA: Aqui é guardado o "Stack Trace" (o erro completo). 
             * Permite que o desenvolvedor leia exatamente por que a tarefa falhou.
             */
            $table->longText('exception');

            /*
             * SINTAXE: $table->timestamp('failed_at')->useCurrent();
             * SEMÂNTICA: Registra o momento exato da falha. 
             * O 'useCurrent()' preenche automaticamente com o horário do servidor no momento do erro.
             */
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    /*
     * SINTAXE: public function down()
     * SEMÂNTICA: Exclui a tabela de registros de falhas caso a migração seja revertida.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
    }
};