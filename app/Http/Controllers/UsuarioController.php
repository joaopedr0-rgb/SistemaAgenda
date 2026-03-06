<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    
    public function index()
    {
        $usuarios = User::where('is_admin', false)->get();
        return view('usuarios.index', compact('usuarios')); // Criar uma view para listar os usuários
    }
   //Create Usuarios 
    public function create()
    {
        return view('usuarios.create'); //criará uma view específ:ica para cadastro de usuários, onde o Admin poderá escolher o tipo (Admin ou Recepcionista)
    }

    // Salva a recepcionista no banco
    public function store(Request $request)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
           
        ]);
        User::create([
        'name' => $dados['name'],
        'email' => $dados['email'],
        'password' => Hash::make($dados['password']),
        'is_admin' => false, // Garante que é recepcionista no banco
    ]);

        
        // Redireciona o Admin de volta para a lista de usuários com uma mensagem de sucesso
        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

        
    public function edit(User $user)
    {
      return view('usuarios.edit',compact('usuarios'));
    }

    public function update(Request $request, User $user)
    {
    	$user->update($request->all());
     	$user->update($request->all());
	return redirect()->route('usuarios.index');


    }

    public function destroy(User $usuarios)
    {
        $usuarios->delete();

        // 2. Apaga o registo

        // 3. Redireciona de volta para a lista com uma mensagem de sucesso
        return redirect()->route('usuarios.index')->with('success', 'Recepcionista excluída com sucesso!');
    }
}
