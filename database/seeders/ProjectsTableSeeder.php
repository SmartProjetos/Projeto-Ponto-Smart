<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            'AI Chemical Dosage',
            'Atividades Administrativas',
            'Automação residencial',
            'Impressões a laser',
            'Manufatura aditiva',
            'Produção de PCBs',
            'Smart Energy Meter',
            'Smart Fish Finder',
            'Smart Flow Hall',
            'Smart Flow Ultra',
            'Smart Hydro',
            'Smart Midea',
            'Smart Sludge',
            'Smart Squeeze',
            'Smart Valve',
            'Novos Recurso',
            'Prospecção de Recurso'
        ];

        foreach ($projects as $project) {
            Project::create(['name' => $project]);
        }
    }
}
