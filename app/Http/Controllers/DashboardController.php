<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $users = User::orderBy('name')->get();

        // $variables = [
        //     'etas' => $etas
        // ];

        // dd($users);

        return view('dashboard', compact('users'));
    }
}
