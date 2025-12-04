<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(){

        //Total Empregados
        $users = Users::all();
        $num_users = count($users);

        //Empregados Ativos
        $ativos = Users::where('status', 'ativo')->get();
        $num_ativos = count($ativos);

        //Empregados em Pausa
        $num_pausas = Users::num_pausas();

        $atividades = Users::atividade_recente();

        //dd($atividades);

        return view('dashboard', compact('users', 'num_users', 'num_ativos', 'num_pausas', 'atividades'));
    }
}
