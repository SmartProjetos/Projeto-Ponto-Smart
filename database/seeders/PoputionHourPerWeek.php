<?php

namespace Database\Seeders;

use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoputionHourPerWeek extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [2, 3, 4, 5, 6]; // IDs dos usuários
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        foreach ($users as $userId) {
            for ($i = 0; $i < 7; $i++) {
                $date = $startOfWeek->addDays($i);
                $entryTime = Carbon::createFromFormat('H:i:s', '08:00:00');
                $departureTime = Carbon::createFromFormat('H:i:s', '17:00:00');

                $totalSeconds = $entryTime->diffInSeconds($departureTime);
                $totalHours = floor($totalSeconds / 3600);
                $totalMinutes = floor(($totalSeconds % 3600) / 60);
                $totalSeconds = $totalSeconds % 60;

                $totalHours = sprintf("%02d:%02d:%02d", $totalHours, $totalMinutes, $totalSeconds);

                Record::create([
                    'user_id' => $userId,
                    'date' => $date->format('Y-m-d'),
                    'entry_time' => $entryTime->format('H:i:s'),
                    'departure_time' => $departureTime->format('H:i:s'),
                    'total_hours' => $totalHours,
                    'total_hours_week' => $totalHours
                ]);
            }
        }
    }
}
