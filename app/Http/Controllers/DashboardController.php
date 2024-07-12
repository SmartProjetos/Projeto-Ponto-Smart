<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $users = User::orderBy('name')->get();

        // Carregar registros de ponto com os usuários relacionados
        $record = Record::with('user')->orderBy('entry_time', 'desc')->get();

        // $variables = [
        //     'etas' => $etas
        // ];

        // dd($users);

        return view('dashboard', compact('users','record'));
    }
}
