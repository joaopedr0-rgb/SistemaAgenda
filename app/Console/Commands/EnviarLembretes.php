<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\LembreteAgendamento;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Agendamento;
use App\Mail\LembreteAgendamento;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EnviarLembretes extends Command
{
    protected $signature = 'enviar:lembretes';
    protected $description = 'Envia e-mails de lembrete para agendamentos de amanhã';

    public function handle()
    {
        // 1. Busca agendamentos de AMANHÃ que estejam pendentes
        $amanha = Carbon::tomorrow()->format('Y-m-d');
        $agendamentos = Agendamento::where('data', $amanha)->where('status', 'pendente')->get();

        foreach ($agendamentos as $agendamento) {
            // 2. Dispara o e-mail para o e-mail do cliente
            Mail::to($agendamento->cliente->email)->send(new LembreteAgendamento($agendamento));
            
            $this->info("Lembrete enviado para: " . $agendamento->cliente->nome);
        }

        $this->info("Todos os lembretes de amanhã foram processados.");
    }
}
