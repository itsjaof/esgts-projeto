<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Users::all();

        return view("empregados", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * Poderia simplesmenter ter feito desta maneira:
     * $user = Users::create([
     *       'name' => $request->input('nome-completo'),
     *       'email' => $request->input('email'),
     *       'position'=> $request->input('cargo'),
     *       'role' => $request->input('type'),
     *       'password' => bcrypt('abc123456'),
     *       'status' => $request->input('status', 'Inativo')
     *   ]);
     *
     *   Mas criei uma instância vazia e coloquei os dados depois para não ter de mexer nos $fillabled no model
     *   de maneira a não criar uma falha de segurança
     */
    public function create(Request $request)
    {
        $user = new Users();

        // Atribuição manual (ignora o $fillable)
        $user->name     = $request->input('nome-completo');
        $user->email    = $request->input('email');
        $user->position = $request->input('cargo');
        $user->role     = $request->input('type');
        $user->status   = $request->input('status', 'Inativo');
        $user->password = bcrypt('abc123456');

        $user->save();

        return redirect()->route('empregados')->with('success', 'Utilizador criado com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Users::find($id);

        if (!$user) {
            return redirect()->route('empregados')->with('error', 'Utilizador não encontrado');
        }

        $user->name = $request->input('nome-completo');
        $user->email = $request->input('email');
        $user->role = $request->input('type');
        $user->position = $request->input('cargo');
        $user->status = $request->input('status', 'Inativo');
        $user->save();

        return redirect()->route('empregados')->with('success', 'Utilizador atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Users::find($id);

        if (!$user) {
            return redirect()->route('empregados')->with('error', 'Utilizador não encontrado');
        }

        $user->delete();

        return redirect()->route('empregados')->with('success', 'Utilizador eliminado com sucesso');
    }
}
