<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;

class CheckExpiredAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired-appointments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

/**
 * Execute the console command.
 */
public function handle()
{
    // Busca agendamentos 'pendentes' onde a data/hora é menor que agora
    Appointment::where('status', 'pendente')
        ->where('scheduled_at', '<', now())
        ->update(['status' => 'expirado']);
    $this->info('Agendamentos expirados verificados e atualizados.');
}

}