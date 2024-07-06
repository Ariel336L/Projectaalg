<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $query = Asistencia::query();

        if ($request->has('estudiante_id')) {
            $query->where('estudiante_id', 'like', '%' . $request->estudiante_id . '%');
        }

        if ($request->has('grupo_id')) {
            $query->where('grupo_id', 'like', '%' . $request->grupo_id . '%');
        }


        $asistencias = $query->orderBy('id', 'desc')->simplePaginate(10);
        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();

        return view('asistencia.index', compact('estudiantes', 'grupos', 'asistencias'));
    }

    public function create()
    {
        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();
        return view('asistencia.create', compact('estudiantes', 'grupos'));
    }

    public function store(Request $request)
    {
        $asistencia = Asistencia::create($request->all());

        return redirect()->route('asistencias.index')->with('success', 'ASISTENCIA CERADA CORRECTAMENTE.');
    }

    public function show($id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {
            return abort(404);
        }

        return view('asistencia.show', compact("asistencia"));
    }

    public function edit($id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {
            return abort(404);
        }

        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();

        return view('asistencia.edit', compact('asistencia', 'estudiantes', 'grupos'));
    }

    public function update(Request $request, $id)
    {
        $asistencia = Asistencia::find($id);


        if (!$asistencia) {
            return abort(404);
        }

        $asistencia->estudiante_id = $request->estudiante_id;
        $asistencia->grupo_id = $request->grupo_id;
        $asistencia->fecha = $request->fecha;
        $asistencia->hora_entrada = $request->hora_entrada;
        $asistencia->save();

        return redirect()->route('asistencias.index')->with('success', 'ASISTENCIA ACTUALIZADA CORRECTAMENTE.');
    }

    public function delete($id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {
            return abort(404);
        }

        return view('asistencia.delete', compact('asistencia'));
    }

    public function destroy($id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {
            return abort(404);
        }

        $asistencia->delete();

        return redirect()
            ->route('asistencias.index')
            ->with('success', 'ASISTENCIA ELIMINADAD CORRECTAMENTE.');
    }

    public function showLoginForm()
    {
        return view('asistencia.marcar');
    }

    public function marcarAsistencia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $pin = $request->input('pin');
        $estudiante = Estudiante::where('pin', $pin)->first();

        if (!$estudiante) {
            return redirect()->back()->withErrors([
                'InvalidCredentials' => 'LAS CREDENCIALES PROPORCIONADAS NO COINCIDEN CON NUESTROS REGISTROS.',
            ]);
        }

        $grupo = Grupo::all()->first();
        $grupoId = $grupo->id;

        $asistencia = new Asistencia();

        $asistencia->estudiante_id = $estudiante->id;
        $asistencia->grupo_id = $grupo->id;

        $asistencia->fecha = now()->format('Y-m-d');
        $asistencia->hora_entrada = now()->format('h:i:s');
        
        $asistencia->ultima_asistencia = now();
        
        $asistencia->save();

        return redirect()
            ->route('asistencias.marcar')
            ->with('success', 'ASISTENCIA GUARDADA CORRECTAMENTE.');
    }
}
