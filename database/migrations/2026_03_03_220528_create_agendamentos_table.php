<?php

/*
 * SINTAXE: use
 * SEMÂNTICA: Importa as ferramentas para manipulação do Schema do banco de dados.
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * SINTAXE: return new class extends Migration
 * SEMÂNTICA: Define a migração para a tabela 'agendamentos'. Esta é uma tabela de "ligação", 
 * pois une informações de diferentes partes do sistema.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
     * SINTAXE: public function up()
     * SEMÂNTICA: Cria a tabela de agendamentos com regras de integridade referencial.
     */
    public function up(): void
    {
        //essa tabela toda usa Foreingn Key, ela está sendo usada para criar os agendamentos que dependem dos clientes e profissionais, então quando um cliente ou profissional for deletado, os agendamentos relacionados a eles também serão deletados, por isso o cascadeOnDelete.
        /*
         * SINTAXE: Schema::create('agendamentos', ...)
         * SEMÂNTICA: Cria a tabela física. O nome no plural em português combina com o seu Model 'Agendamento'.
         */
        Schema::create('agendamentos', function (Blueprint $table) {
            
            // SINTAXE: $table->id();
            // SEMÂNTICA: Identificador único do agendamento.
            $table->id();

            /*
             * SINTAXE: $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
             * SEMÂNTICA: 
             * 1. foreignId: Cria uma coluna para guardar o ID do cliente.
             * 2. constrained('clientes'): Diz ao banco: "Essa coluna SÓ aceita IDs que existam na tabela clientes".
             * 3. cascadeOnDelete(): Como você explicou, se o Cliente 5 for deletado, todos os agendamentos 
             * do Cliente 5 somem automaticamente. Isso evita "dados órfãos" no banco.
             */
            $table ->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table ->foreignId('servico_id')->constrained('servicos')->cascadeOnDelete();

             /*
             * SINTAXE: $table->foreignId('profissional_id')...
             * SEMÂNTICA: Exatamente a mesma lógica acima, mas vinculando o agendamento a um Profissional.
             */

            /*
             * SINTAXE: $table->foreignId('profissional_id')...
             * SEMÂNTICA: Exatamente a mesma lógica acima, mas vinculando o agendamento a um Profissional.
             */
            $table->foreignId('profissional_id')->constrained('profissionais')->cascadeOnDelete();

            /*
             * SINTAXE: $table->date('data')->nullable();
             * SEMÂNTICA: Cria uma coluna específica para datas (AAAA-MM-DD). 
             * O 'nullable' permite criar um registro de agendamento "em rascunho" sem data definida.
             */
            $table->date('data')->nullable();

            /*
             * SINTAXE: $table->time('hora')->nullable();
             * SEMÂNTICA: Cria uma coluna para o horário (HH:MM:SS). 
             * Separar data e hora em colunas diferentes facilita buscas como "todos os agendamentos das 14:00".
             */
            $table->time('hora')->nullable();

            /*
             * SINTAXE: $table->string('status')->default('pendente');
             * SEMÂNTICA: Define o estado atual do agendamento. 
             * Começa como 'pendente' e mudará para 'concluido' quando o serviço for finalizado.
             */
            $table->string('status')->default('pendente');

            /*
             * SINTAXE: $table->decimal('valor_comissao_pago', 8, 2)->default(0.00);
             * SEMÂNTICA: 💰 IMPORTANTE! Registra o valor exato em Reais que o profissional ganhou.
             * Salvamos aqui para que, se o preço do serviço mudar no futuro, o histórico financeiro 
             * deste atendimento permaneça correto.
             */
            $table->decimal('valor_comissao_pago', 8, 2)->default(0.00);

            /*
             * SINTAXE: $table->timestamps();
             * SEMÂNTICA: Registra quando o agendamento foi marcado e quando foi alterado pela última vez.
             */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    /*
     * SINTAXE: public function down()
     * SEMÂNTICA: Remove a tabela de agendamentos do banco.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};