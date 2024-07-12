<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    // Exibir histórico de registros de ponto
    public function index()
    {
        $record = Record::with('user_id')->orderBy('entry_time', 'desc')->get();
        // dd($record);
        return view('layouts.record.record_index', compact('record'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'punched_in_at' => 'required|date_format:H:i',
            'punched_out_at' => 'nullable|date_format:H:i|after:punched_in_at',
            'project1_name' => 'nullable|string',
            'project1_hours' => 'nullable|date_format:H:i',
            'project2_name' => 'nullable|string',
            'project2_hours' => 'nullable|date_format:H:i',
            'project3_name' => 'nullable|string',
            'project3_hours' => 'nullable|date_format:H:i',
        ]);


        // dd($request);
        // Armazena o registro de punch
        Record::create([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'punched_in_at' => $request->punched_in_at,
            'punched_out_at' => $request->punched_out_at,
            'total_hours' => $request->total_hours,
            'project1_name' => $request->project1_name,
            'project1_hours' => $request->project1_hours,
            'project2_name' => $request->project2_name,
            'project2_hours' => $request->project2_hours,
            'project3_name' => $request->project3_name,
            'project3_hours' => $request->project3_hours,
        ]);

        // Outras ações após salvar, como redirecionamento ou mensagem de sucesso
        return redirect()->route('dashboard')->with('success', 'Horario adicionado com sucesso!');
    }

    // PunchController.php

    public function edit($id)
    {
        $punchSolo = Record::findOrFail($id);
        // $employees = Employee::all();
        // $projects = Project::all();

        // dd($punchSolo);
        return view('partials.edit_punches', compact('punchSolo', 'employees', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $punch = Record::findOrFail($id);

        $punch->update($request->all());

        //dd($punch);

        return redirect()->route('punches.show', ['punch' => $punch->id])->with('success', 'Registro atualizado com sucesso!');

    }

    public function show($id)
    {
        $punch = Record::findOrFail($id);
        return view('partials.show_punches', compact('punch'));
    }
}
