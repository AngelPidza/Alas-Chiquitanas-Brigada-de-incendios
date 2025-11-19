<?php

namespace App\Http\Controllers;

use App\Models\CondicionesClimatica;
use Illuminate\Http\Request;

class CondicionClimaticaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $condiciones = CondicionesClimatica::orderBy('codigo')->get();
        return view('condiciones_climaticas.index', compact('condiciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('condiciones_climaticas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:condiciones_climaticas,codigo',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'factor_riesgo' => 'nullable|integer|min:1|max:10',
        ]);

        CondicionesClimatica::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'factor_riesgo' => $request->factor_riesgo,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('condiciones-climaticas.index')
            ->with('success', 'Condición climática creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $condicion = CondicionesClimatica::findOrFail($id);
        return view('condiciones_climaticas.show', compact('condicion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $condicion = CondicionesClimatica::findOrFail($id);
        return view('condiciones_climaticas.edit', compact('condicion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $condicion = CondicionesClimatica::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|max:50|unique:condiciones_climaticas,codigo,' . $id,
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'factor_riesgo' => 'nullable|integer|min:1|max:10',
        ]);

        $condicion->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'factor_riesgo' => $request->factor_riesgo,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('condiciones-climaticas.index')
            ->with('success', 'Condición climática actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $condicion = CondicionesClimatica::findOrFail($id);
            $condicion->delete();

            return redirect()->route('condiciones-climaticas.index')
                ->with('success', 'Condición climática eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('condiciones-climaticas.index')
                ->with('error', 'Error al eliminar la condición climática. Puede estar en uso.');
        }
    }
}
