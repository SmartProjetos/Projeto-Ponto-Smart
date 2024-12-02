<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecordAdminController extends Controller
{
    public function index2()
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
        return view('layouts.dashboardadmin.dashboardadmin', compact('users', 'record', 'hoursPerWeekByUser'));
    }

    public function index($id, Request $request)
    {
        // dd($request);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        // Pegando o valor do filtro do request
        $filter = $request->input('filter', '30d'); // Default to '30d' if not provided

        // Definindo a data de início com base no filtro selecionado
        $startDate = Carbon::now()->subDays(30); // Default to last 30 days

        switch ($filter) {
            case '1d':
                $startDate = Carbon::now()->subDay();
                break;
            case '7d':
                $startDate = Carbon::now()->subDays(7);
                break;
            case '30d':
                $startDate = Carbon::now()->subDays(30);
                break;
            case '1m':
                $startDate = Carbon::now()->subMonth();
                break;
            case '1y':
                $startDate = Carbon::now()->subYear();
                break;
        }

        // Consultando os registros com base no filtro
        $records = Record::where('user_id', $id)
            ->where('date', '>=', $startDate)
            ->orderBy('date', 'desc')
            ->get();

        $groupedRecords = $records->groupBy(function ($item) {
            return Carbon::parse($item->date)->format('d/m/Y');
        });
        $hoursPerWeek = ControllerHoursPerWeek::getHoursPerWeekByUser($id);
        // dd($hoursPerWeek);
        return view('layouts.record.record_admin', compact('records', 'user', 'groupedRecords', 'hoursPerWeek'));
    }


    public function show($user, $punch)
    {
        // dd($user);

        // Buscar o registro com base no ID
        $punch = Record::where('user_id', $user)->findOrFail($punch);
        $user_id = $user = User::find($user);
        // dd($user_id);
        return view('layouts.record.record_adminshow', compact('punch', 'user_id'));
    }


}
