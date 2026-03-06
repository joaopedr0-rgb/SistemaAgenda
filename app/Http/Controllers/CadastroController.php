<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CadastroController extends Controller
{




    public function create()
    {
        // Sintaxe: retorna uma função auxiliar view().
        // Semântica: Carrega o arquivo HTML localizado em resources/views/cadastro/index.blade.php.
        return view('cadastro.index');
    }

    /*
     *
     * Semântica: Recebe os dados do formulário e salva no banco de dados.
     *
     */
    public function store(Request $request)
    {
        // --- ETAPA 1: VALIDAÇÃO ---
        // Sintaxe: $request->validate([regras]). 
        // Semântica: Protege o banco. Se algo falhar (ex: e-mail duplicado), o Laravel para aqui e volta com erro.
        $dados = $request->validate([
            'name'     => ['required', 'string', 'max:255'], // Obrigatório, texto, limite de caracteres.
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'], // Deve ser e-mail único na tabela users.
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Mínimo 8 caracteres; exige campo 'password_confirmation'.
        ]);

        // --- ETAPA 2: CRIAÇÃO ---
        // Sintaxe: Método estático User::create([]).
        // Semântica: Transforma o array de dados em uma linha na tabela do SQL.
        User::create([
            'name'     => $dados['name'],
            'email'    => $dados['email'],
            
            // Sintaxe: Hash::make().
            // Semântica: Criptografia. Nunca salvamos a senha "limpa" por segurança.
            'password' => Hash::make($dados['password']),
            
            // Semântica: Define manualmente que este usuário é um Administrador.
            'is_admin' => true, 
        ]);

        // --- ETAPA 3: RESPOSTA ---
        // Sintaxe: redirect()->route('nome_da_rota').
        // Semântica: Após salvar, manda o usuário para a página inicial de clientes.
        return redirect()->route('clientes.index');
    }

   
    public function edit(User $user)
    {
	        
    }

   
    public function update(Request $request, User $user)
    {
        
    }

    
    public function destroy(User $user)
    {
       
    }
}
