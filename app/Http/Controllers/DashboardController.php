<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Panel\ControllerHoursPerWeek;
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
        $hoursPerWeekByUser = [];
        foreach ($users as $user) {
            $hoursPerWeekByUser[$user->name] = ControllerHoursPerWeek::getHoursPerWeekByUser($user->id);
        }
        // dd($hoursPerWeekByUser);
        return view('dashboard', compact('users', 'record', 'hoursPerWeekByUser'));
    }
}
