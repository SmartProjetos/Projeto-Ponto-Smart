<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $weeklyHoursInMinutes = $this->convertWeeklyHoursToMinutes($user->weekly_hours);
        $hoursByMonth = $this->getHoursByMonth($id);

        $months = [];
        $totalMinutes = [];

        foreach ($hoursByMonth as $record) {
            $totalMinutesInRecord = $this->convertTimeToMinutes($record->total_hours);
            $months[] = Carbon::createFromFormat('m', $record->month)->format('M');
            $totalMinutes[] = $totalMinutesInRecord;
        }

        // Obtendo horas registradas na semana atual
        $totalMinutesInWeek = $this->getHoursByCurrentWeek($id);

        // Calculando o saldo de horas
        $balanceMinutes = $totalMinutesInWeek - $weeklyHoursInMinutes;
        $weeklyBalance = $this->formatBalance($balanceMinutes);


        if ($request->isMethod('post') && $request->has(['start-date', 'end-date'])) {
            try {
                $startDate = Carbon::parse($request->input('start-date'))->startOfDay();
                $endDate = Carbon::parse($request->input('end-date'))->endOfDay();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors('Erro ao processar as datas.');
            }
        } else {
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        }

        $records = Record::where('user_id', $user->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        $groupedRecords = $records->groupBy(function ($item) {
            return Carbon::parse($item->date)->locale('pt_BR')->translatedFormat('l, d/m/Y');
        });

        $user_week = $user->weekly_hours;
        $hoursPerWeek = ControllerHoursPerWeek::getHoursPerWeekByUser($user->id);
        // dd($hoursPerWeek);
        return view('layouts.record.record_admin', compact(
            'records',
            'user',
            'groupedRecords',
            'hoursPerWeek',
            'months',
            'totalMinutes',
            'user_week',
            'weeklyBalance'
        ));
    }

    private function convertWeeklyHoursToMinutes($weeklyHours)
    {
        if (empty($weeklyHours)) {
            throw new \InvalidArgumentException('Carga horária semanal não definida para o usuário.');
        }

        $timeParts = explode(':', $weeklyHours);
        $hours = (int)$timeParts[0];
        $minutes = (int)$timeParts[1];

        return ($hours * 60) + $minutes;
    }

    private function getHoursByMonth($userId)
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        return DB::table('records')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(total_hours))) as total_hours')
            )
            ->where('created_at', '>=', $sixMonthsAgo)
            ->where('user_id', $userId)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();
    }

    private function getHoursByCurrentWeek($userId)
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Início da semana
        $endOfWeek = Carbon::now()->endOfWeek(); // Fim da semana
        return DB::table('records')
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum(DB::raw('TIME_TO_SEC(total_hours)')) / 60; // Convertendo segundos para minutos
    }

    private function convertTimeToMinutes($time)
    {
        $timeParts = explode(':', $time);
        $hours = (int)$timeParts[0];
        $minutes = (int)$timeParts[1];

        return ($hours * 60) + $minutes;
    }

    private function formatBalance($balanceMinutes)
    {
        $hours = intdiv(abs($balanceMinutes), 60);
        $minutes = abs($balanceMinutes) % 60;
        $sign = $balanceMinutes >= 0 ? '(extra)' : '(débito)';

        $formattedValue = sprintf('%02d:%02d', $hours, $minutes);

        return [
            'value' => $formattedValue,
            'sign' => $sign,
        ];
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
