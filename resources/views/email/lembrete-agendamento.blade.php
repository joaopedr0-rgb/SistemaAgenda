<h1>Olá, {{ $agendamento->cliente->nome }}!</h1>
<p>Passando para lembrar do seu horário marcado no nosso salão:</p>

<ul>
    <li><strong>Serviço:</strong> {{ $agendamento->servico->nome }}</li>
    <li><strong>Data:</strong> {{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}</li>
    <li><strong>Horário:</strong> {{ $agendamento->hora }}</li>
    <li><strong>Profissional:</strong> {{ $agendamento->profissional->nome }}</li>
</ul>

<p>Esperamos por você!</p>