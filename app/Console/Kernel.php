<?php

/*
SINTAXE: 'namespace' organiza a localização da classe dentro do projeto.
SEMÂNTICA: Define que esta classe pertence ao núcleo de comandos do Console do Laravel (App\Console).
*/
namespace App\Console;

/*
SINTAXE: 'use' importa as classes necessárias para o agendamento e o funcionamento do Kernel.
SEMÂNTICA: Importamos o 'Schedule' (responsável por gerenciar o tempo das tarefas) e o 'ConsoleKernel' (a base do Laravel para comandos de terminal).
*/
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/*
SINTAXE: 'class Kernel extends ConsoleKernel'
SEMÂNTICA: Criamos o Kernel do Console. Ele funciona como o "Relógio Central" do salão. É aqui que decidimos quais tarefas devem ser feitas sozinhas, sem que ninguém precise clicar em botões.
*/
class Kernel extends ConsoleKernel
{
    /*
    SINTAXE: $schedule->command('assinatura')->frequencia();
    SEMÂNTICA: Registro do Lembrete. 
    1. command('enviar:lembretes'): Chama o comando que você criou para disparar os e-mails.
    2. dailyAt('08:00'): Define a regra de negócio: todo dia, pontualmente às 08h da manhã, o sistema vai varrer o banco de dados e avisar as clientes sobre os agendamentos do dia seguinte.
    */
    protected function schedule(Schedule $schedule): void
    {
        // Agendando o comando de enviar lembrete para rodar todo dia às 08:00
        $schedule->command('enviar:lembretes')->dailyAt('08:00');
    }

    /**
     * SINTAXE: 'protected function commands(): void'
     * SEMÂNTICA: Este método é o responsável por "enxergar" os comandos que você cria manualmente.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        /*
        SINTAXE: require base_path('routes/console.php');
        SEMÂNTICA: Carrega rotas específicas de console, permitindo interações rápidas via terminal se necessário.
        */
        require base_path('routes/console.php');
    }
}
