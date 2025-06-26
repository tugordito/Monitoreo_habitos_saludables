<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habito;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HabitoController extends Controller
{
    public function index()
    {
        $habitos = Habito::where('user_id', Auth::id())
                        ->orderBy('fecha', 'desc')
                        ->get();

        return view('habitos.index', compact('habitos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'agua' => 'nullable|numeric',
            'sueno' => 'nullable|numeric',
            'actividad_fisica' => 'nullable|numeric',
            'alimentacion' => 'nullable|string|max:255',
        ]);

        Habito::create([
            'user_id' => Auth::id(),
            'fecha' => $request->fecha,
            'agua' => $request->agua,
            'sueno' => $request->sueno,
            'actividad_fisica' => $request->actividad_fisica,
            'alimentacion' => $request->alimentacion,
        ]);

        return redirect()->route('habitos.index')->with('success', 'Hábito guardado.');
    }

    public function edit($id)
    {
        $habito = Habito::findOrFail($id);
        if ($habito->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }
        return view('habitos.edit', compact('habito'));
    }

    public function update(Request $request, $id)
    {
        $habito = Habito::findOrFail($id);
        if ($habito->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'fecha' => 'required|date',
            'agua' => 'nullable|numeric',
            'sueno' => 'nullable|numeric',
            'actividad_fisica' => 'nullable|numeric',
            'alimentacion' => 'nullable|string|max:255',
        ]);

        $habito->update($request->all());

        return redirect()->route('habitos.index')->with('success', 'Hábito actualizado.');
    }

    public function destroy($id)
    {
        $habito = Habito::findOrFail($id);
        if ($habito->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }
        $habito->delete();

        return redirect()->route('habitos.index')->with('success', 'Hábito eliminado.');
    }    public function reporte()
    {
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();

        $habitos = Habito::where('user_id', Auth::id())
                        ->whereBetween('fecha', [$inicioSemana, $finSemana])
                        ->orderBy('fecha')
                        ->get();

        // Datos para Chart.js
        $labels = [];
        $agua = [];
        $sueno = [];
        $ejercicio = [];

        foreach ($habitos as $habito) {
            $labels[] = Carbon::parse($habito->fecha)->locale('es')->isoFormat('dddd D');
            $agua[] = (float) ($habito->agua ?? 0);
            $sueno[] = (float) ($habito->sueno ?? 0);
            $ejercicio[] = (float) ($habito->actividad_fisica ?? 0);
        }

        // Si no hay datos, crear datos de ejemplo para mostrar el gráfico
        if (empty($labels)) {
            $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            $labels = $diasSemana;
            $agua = array_fill(0, 7, 0);
            $sueno = array_fill(0, 7, 0);
            $ejercicio = array_fill(0, 7, 0);
        }

        return view('habitos.reporte', compact('habitos', 'labels', 'agua', 'sueno', 'ejercicio'));
    }


    public function recomendaciones()
    {
        $habitos = Habito::where('user_id', Auth::id())
                        ->latest('fecha')
                        ->take(7)
                        ->get();

        $recomendaciones = [];

        $promedioSueno = $habitos->avg('sueno');
        if ($promedioSueno < 6) {
            $recomendaciones[] = "Duerme al menos 6 horas por noche.";
        }

        $promedioAgua = $habitos->avg('agua');
        if ($promedioAgua < 1.5) {
            $recomendaciones[] = "Incrementa tu consumo de agua.";
        }

        if ($habitos->avg('actividad_fisica') < 30) {
            $recomendaciones[] = "Realiza al menos 30 minutos de actividad física diaria.";
        }

        return view('habitos.recomendaciones', compact('recomendaciones'));
    }
}
