<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //essa tabela toda usa Foreingn Key, ela está sendo usada para criar os agendamentos que dependem dos clientes e profissionais, então quando um cliente ou profissional for deletado, os agendamentos relacionados a eles também serão deletados, por isso o cascadeOnDelete.
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table ->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('profissional_id')->constrained('profissionais')->cascadeOnDelete();
            $table->foreignId('servico_id')->constrained('servicos')->cascadeOnDelete();
            $table->date('data')->nullable();
            $table->time('hora')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
