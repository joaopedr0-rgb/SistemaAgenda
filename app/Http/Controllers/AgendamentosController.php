<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Servico;
use Illuminate\Http\Request;

// 🔥 GOOGLE
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class AgendamentosController extends Controller
{
    public function index()
    {
        $agendamentos = Agendamento::all();
        $clientes = Cliente::all();
        $profissionais = Profissional::all();
        $servicos = Servico::all();

        return view('agendamentos.index', compact('agendamentos', 'clientes', 'profissionais', 'servicos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $profissionais = Profissional::all();
        $servicos = Servico::all();

        return view('agendamentos.create', compact('clientes', 'profissionais', 'servicos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'      => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'servico_id'      => 'required|exists:servicos,id',
            'data'            => 'required|date',
            'hora'            => 'required|date_format:H:i',
            'status'          => 'required',
            'valor_comissao_pago' => 'required'
        ]);

        // 🔥 SALVA NO BANCO
        $agendamento = Agendamento::create($validated);

        // 🔥 GOOGLE AGENDA
        if (session('google_token')) {

            $client = new Google_Client();
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

            $client->setHttpClient(new \GuzzleHttp\Client([
                'verify' => false,
            ]));

            $client->setAccessToken(session('google_token'));

            $service = new Google_Service_Calendar($client);

            $event = new Google_Service_Calendar_Event([
                'summary' => 'Agendamento - ID ' . $agendamento->id,
                'description' => 'Agendamento criado pelo sistema',
                'start' => [
                    'dateTime' => $request->data . 'T' . $request->hora . ':00',
                    'timeZone' => 'America/Sao_Paulo',
                ],
                'end' => [
                    'dateTime' => $request->data . 'T' . $request->hora . ':00',
                    'timeZone' => 'America/Sao_Paulo',
                ],
            ]);

            $service->events->insert('primary', $event);
        }

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado!');
    }

    public function edit(Agendamento $agendamento)
    {
        $clientes = Cliente::all();
        $profissionais = Profissional::all();
        $servicos = Servico::all();

        return view('agendamentos.edit', compact('agendamento', 'clientes', 'profissionais', 'servicos'));
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $validated = $request->validate([
            'cliente_id'      => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'servico_id'      => 'required|exists:servicos,id',
            'data'            => 'required|date',
            'hora'            => 'required',
        ]);

        $agendamento->update($validated);

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado!');
    }

    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();
        
        return redirect()->route('agendamentos.index')->with('success', 'Agendamento removido!');
    }

    public function exportarExcel()
    {
        $agendamentos = Agendamento::with(['cliente', 'servico', 'profissional'])->get();
        $fileName = 'agendamentos_salao.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Cliente', 'Serviço', 'Profissional', 'Data', 'Hora', 'Status', 'Comissão'];

        $callback = function() use($agendamentos, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ';');

            foreach ($agendamentos as $agendamento) {
                fputcsv($file, [
                    $agendamento->id,
                    $agendamento->cliente->nome,
                    $agendamento->servico->nome,
                    $agendamento->profissional->nome,
                    $agendamento->data,
                    $agendamento->hora,
                    $agendamento->status,
                    $agendamento->valor_comissao_pago
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function concluir(Agendamento $agendamento)
    {
        $servico = $agendamento->servico;

        $valorComissao = ($servico->preco * $servico->comissao_percentual) / 100;

        $agendamento->update([
            'status' => 'concluido',
            'valor_comissao_pago' => $valorComissao,
        ]);

        return redirect()->route('agendamentos.index')->with('success', 'Serviço finalizado e comissão calculada!');
    }
}