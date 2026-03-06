<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recepcionistas = User::where('is_admin', false)->get();
        return view('recepcionista.index', compact('recepcionistas')); // Criar uma view para listar os usuários
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recepcionista.create'); //criará uma view específica para cadastro de usuários, onde o Admin poderá escolher o tipo (Admin ou Recepcionista)
    }

    // Salva a recepcionista no banco
    public function store(Request $request)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
             // O Admin escolhe o perfil no form
        ]);

        $dados['password'] = Hash::make($dados['password']);

        User::create($dados);

        // Redireciona o Admin de volta para a lista de usuários com uma mensagem de sucesso
        return redirect()->route('recepcionista.index')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $recepcionista)
    {
        $recepcionista->delete();

        // 2. Apaga o registo

        // 3. Redireciona de volta para a lista com uma mensagem de sucesso
        return redirect()->route('recepcionista.index')->with('success', 'Recepcionista excluída com sucesso!');
    }
}
