<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $user = User::findOrFail($userId);

        $weeklyHoursInMinutes = $this->convertWeeklyHoursToMinutes($user->weekly_hours);
        $hoursByMonth = $this->getHoursByMonth($userId);

        $months = [];
        $totalMinutes = [];

        foreach ($hoursByMonth as $record) {
            $totalMinutesInRecord = $this->convertTimeToMinutes($record->total_hours);
            $months[] = Carbon::createFromFormat('m', $record->month)->format('M');
            $totalMinutes[] = $totalMinutesInRecord;
        }

        // Obtendo horas registradas na semana atual
        $totalMinutesInWeek = $this->getHoursByCurrentWeek($userId);

        // Calculando o saldo de horas
        $balanceMinutes = $totalMinutesInWeek - $weeklyHoursInMinutes;
        $formattedBalance = $this->formatBalance($balanceMinutes);

        return view('dashboard', [
            'months' => $months,
            'totalMinutes' => $totalMinutes,
            'weeklyBalance' => $formattedBalance,
            'user_week' => $user->weekly_hours,
        ]);
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
}
