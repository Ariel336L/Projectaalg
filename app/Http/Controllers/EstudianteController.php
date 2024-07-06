<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;


class EstudianteController extends Controller
{
    public function index(Request $request)
    {
        $query = Estudiante::query();

        if ($request->has('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->has('apellido')) {
            $query->where('apellido', 'like', '%' . $request->apellido . '%');
        }

        $estudiantes = $query->orderBy('id', 'desc')->simplePaginate(10);

        return view('estudiante.index', compact('estudiantes'));
    }

    public function create()
    {
        return view('estudiante.create');
    }

    public function store(Request $request)
    {
        $estudiante = Estudiante::create($request->all());

        return redirect()->route('estudiantes.index')->with('success', 'ESTUDIANTE CREADO CORRECTAMENTE');
    }

    public function show($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return abort(404);
        }

        return view('estudiante.show', compact('estudiante'));
    }

    public function edit($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return abort(404);
        }

        return view('estudiante.edit', compact('estudiante'));
    }

    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return abort(404);
        }

        $estudiante->nombre = $request->nombre;
        $estudiante->apellido = $request->apellido;
        $estudiante->email = $request->email;

        $estudiante->save();

        return redirect()->route('estudiantes.index')->with('success', 'ESTUDIANTE MODIFICADO CORRECTAMENTE');
    }

    public function delete($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return abort(404);
        }

        return view('estudiante.delete', compact('estudiante'));
    }

    public function destroy($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return abort(404);
        }

        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('success', 'ESTUDIANTE ELIMINADO CORRECTAMENTE');
    }
}
