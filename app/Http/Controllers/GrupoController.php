<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{

    public function index(Request $request)
    {
        $query = Grupo::query();

        if ($request->has('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $grupos = $query->orderBy('id', 'desc')->simplePaginate(10);

        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        return view('grupos.create');
    }

    public function store(Request $request)
    {
        $grupo = Grupo::create($request->all());

        return redirect()->route('grupos.index')->with('success','GRUPO CREADO CORRECTAMENTE'); 
    }

    public function show($id)
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return abort(404);
        }
        
        return view('grupos.show', compact('grupo'));
    }

    public function edit($id)
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return abort(404);
        }
        
        return view('grupos.edit', compact('grupo'));
    }

    public function update(Request $request, $id)
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return abort(404);
        }

        $grupo->nombre = $request->nombre;
        $grupo->descripcion = $request->descripcion;
        $grupo->save();
        
        return redirect()->route('grupos.index')->with('success','GRUPO MODIFICADO CORRECTAMENTE'); 
    }

    public function delete($id){
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return abort(404);
        }
        
        return view('grupos.delete', compact('grupo'));
    }

    public function destroy($id)
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return abort(404);
        }

        $grupo->delete();
        
        return redirect()->route('grupos.index')->with('success','GRUPO ELIMINADO CORRECTAMENTE'); 
    }
}