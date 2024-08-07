<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    // Exibir histórico de registros de ponto
    public function index(Request $request)
    {
        $user = auth()->user();

        // Pegando o valor do filtro do request
        $filter = $request->input('filter', '30d'); // Default to '30d' if not provided

        // Definindo a data de início com base no filtro selecionado
        $startDate = Carbon::now()->subDays(30); // Default to last 30 days

        switch ($filter) {
            case '1d':
                $startDate = Carbon::now()->startOfDay();
                break;
            case '7d':
                $startDate = Carbon::now()->subDays(7)->startOfDay();
                break;
            case '30d':
                $startDate = Carbon::now()->subDays(30)->startOfDay();
                break;
            case '1m':
                $startDate = Carbon::now()->subMonth()->startOfDay();
                break;
            case '1y':
                $startDate = Carbon::now()->subYear()->startOfDay();
                break;
        }

        // Consultando os registros com base no filtro
        $records = Record::where('user_id', $user->id)
            ->whereDate('date', '>=', $startDate) // Use `whereDate` to compare only the date part
            ->orderBy('date', 'desc')
            ->get();

        // Agrupando os registros por data
        $groupedRecords = $records->groupBy(function ($item) {
            return Carbon::parse($item->date)->format('d/m/Y');
        });
        //dd($groupedRecords);

        $hoursPerWeek = ControllerHoursPerWeek::getHoursPerWeekByUser($user->id);

        return view('layouts.record.record_index', compact('records', 'user', 'groupedRecords', 'hoursPerWeek'));
    }



    public function create()
    {
        $record = Record::all();
        $projects = Project::all();
        return view('layouts.record.record_add', compact('record', 'projects'));
    }

    public function store(Request $request)
    {
        // dd($request->user_id);

        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'entry_time' => 'required|date_format:H:i',
            'departure_time' => 'nullable|date_format:H:i|after:punched_in_at',
            'project1_name' => 'nullable|string',
            'project1_hours' => 'nullable|date_format:H:i',
            'project2_name' => 'nullable|string',
            'project2_hours' => 'nullable|date_format:H:i',
            'project3_name' => 'nullable|string',
            'project3_hours' => 'nullable|date_format:H:i',
            'project4_name' => 'nullable|string',
            'project4_hours' => 'nullable|date_format:H:i',
            'project5_name' => 'nullable|string',
            'project5_hours' => 'nullable|date_format:H:i',
            'project6_name' => 'nullable|string',
            'project6_hours' => 'nullable|date_format:H:i',
            'textarea1' => 'nullable|string',
            'textarea2' => 'nullable|string',
            'textarea3' => 'nullable|string',
            'textarea4' => 'nullable|string',
            'textarea5' => 'nullable|string',
            'textarea6' => 'nullable|string',
        ]);


        // dd($request);
        // Armazena o registro de punch
        Record::create([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'entry_time' => $request->entry_time,
            'departure_time' => $request->departure_time,
            'total_hours' => $request->total_hours,
            'project1_name' => $request->project1_name,
            'project1_hours' => $request->project1_hours,
            'project2_name' => $request->project2_name,
            'project2_hours' => $request->project2_hours,
            'project3_name' => $request->project3_name,
            'project3_hours' => $request->project3_hours,
            'project4_name' => $request->project4_name,
            'project4_hours' => $request->project4_hours,
            'project5_name' => $request->project5_name,
            'project5_hours' => $request->project5_hours,
            'project6_name' => $request->project6_name,
            'project6_hours' => $request->project6_hours,
            'textarea1' => $request->textarea1,
            'textarea2' => $request->textarea2,
            'textarea3' => $request->textarea3,
            'textarea4' => $request->textarea4,
            'textarea5' => $request->textarea5,
            'textarea6' => $request->textarea6,
        ]);

        // dd($request);
        // Redirecionar para a rota index com mensagem de sucesso
        return redirect()->route('record.index')->with('success', 'Horário adicionado com sucesso!');
    }

    // PunchController.php

    public function edit($id)
    {
        $record = Record::findOrFail($id);
        $projects = Project::all();

        // dd($projects);
        return view('layouts.record.record_edit', compact('record',  'projects'));
    }

    public function update(Request $request, $id)
    {
        $punch = Record::findOrFail($id);

        $punch->update($request->all());

        //dd($punch);

        return redirect()->route('record.show', ['punch' => $punch->id])->with('success', 'Registro atualizado com sucesso!');
    }

    public function show($id)
    {
        $punch = Record::findOrFail($id);
        return view('layouts.record.record_show', compact('punch'));
    }

    public function destroy($id)
    {
        $record = Record::find($id);
        // dd($record);
        if ($record) {
            $record->delete();
            return redirect()->route('record.index')->with('success', 'Registro de ponto excluído com sucesso!');
        } else {
            return redirect()->route('record.index')->with('error', 'Registro de ponto não encontrado.');
        }
    }
}
