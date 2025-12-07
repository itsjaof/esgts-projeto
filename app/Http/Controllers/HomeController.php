<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(){

        //Elements for the first grid on dashboard
        $elements = Users::dashboardElements();
        //dd($elements);

        //Array with the data for the grid at recently activities
        $activities = Users::recentlyActivities();
        //dd($atividades);

        return view('dashboard', compact('elements', 'activities'));
    }
}
