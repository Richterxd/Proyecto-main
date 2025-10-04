<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;

class TrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trabajadores = \App\Models\Trabajador::all();
        return route('trabajador.indexDos');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('livewire.dashboard.personas.trabajadores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'nacionalidad' => 'required|in:V,E',
            'cedula' => 'required|unique:trabajadores',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required',
            'correo' => 'required|email|unique:trabajadores',
            'direccion' => 'required',
            'zona_trabajo' => 'required',
            'cantidad_hijos' => 'required|integer|min:0',
        ]);

        Trabajador::create($validated);
        return redirect()->route('trabajador.indexDos')->with('success', 'Trabajador registrado correctamente');
    }

    public function show($id)
    {
        $trabajador = Trabajador::findOrFail($id);
        return view('livewire.dashboard.personas.trabajadores.show', compact('trabajador'));
    }


    public function edit(Trabajador $trabajador)
    {
        return view('livewire.dashboard.personas.trabajadores.edit', compact('trabajador'));
    }

    public function update(Request $request, Trabajador $trabajador)
    {
        $validated = $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'nacionalidad' => 'required|in:V,E',
            'cedula' => 'required|unique:trabajadores,cedula,' . $trabajador->cedula . ',cedula',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required',
            'correo' => 'required|email|unique:trabajadores,correo,' . $trabajador->cedula . ',cedula',
            'direccion' => 'required',
            'zona_trabajo' => 'required',
            'cantidad_hijos' => 'required|integer|min:0',
        ]);

        $trabajador->update($validated);
        return redirect()->route('trabajador.indexDos')->with('success', 'Trabajador actualizado correctamente');
    }

    public function destroy(Trabajador $trabajador)
    {
        $trabajador->delete();
        return redirect()->route('trabajador.indexDos')->with('success', 'Trabajador eliminado correctamente');
    }
}
