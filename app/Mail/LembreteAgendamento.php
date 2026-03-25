<?php

namespace App\Mail;

use App\Models\Agendamento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LembreteAgendamento extends Mailable
{
    use Queueable, SerializesModels;

    public $agendamento;


    
    public function __construct(Agendamento $agendamento)
    {
        //Aqui passa os dados do agendamento para o email.
        $this->agendamento = $agendamento;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lembrete de Horário Marcado:'.$this->agendamento->servico->nome,);
    }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.lembrete-agendamento',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
