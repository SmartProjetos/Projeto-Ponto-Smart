<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerHoursPerWeek extends Controller
{
    public static function getHoursPerWeekByUser($user)
    {
        $records = Record::where('user_id', $user)
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();

        $totalSeconds = 0;
        foreach ($records as $record) {
            if (!empty($record->departure_time)) {
                $entryTime = Carbon::createFromFormat('H:i:s', $record->entry_time);
                $departureTime = Carbon::createFromFormat('H:i:s', $record->departure_time);
                $totalSeconds += $entryTime->diffInSeconds($departureTime);
            }
            // $entryTime = Carbon::createFromFormat('H:i:s', $record->entry_time);
            // $departureTime = Carbon::createFromFormat('H:i:s', $record->departure_time);
            // $totalSeconds += $entryTime->diffInSeconds($departureTime);
        }

        $totalHours = floor($totalSeconds / 3600);
        $totalMinutes = floor(($totalSeconds % 3600) / 60);
        $totalSeconds = $totalSeconds % 60;

        $hoursPerWeek = sprintf("%02d:%02d", $totalHours, $totalMinutes);

        return $hoursPerWeek;
    }
}
