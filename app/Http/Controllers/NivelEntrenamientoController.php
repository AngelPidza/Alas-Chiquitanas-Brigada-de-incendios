<?php

namespace App\Http\Controllers;

use App\Models\NivelesEntrenamiento;
use Illuminate\Http\Request;

class NivelEntrenamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $niveles = NivelesEntrenamiento::orderBy('orden')->get();
        return view('niveles_entrenamiento.index', compact('niveles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('niveles_entrenamiento.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nivel' => 'required|string|max:50|unique:niveles_entrenamiento,nivel',
            'descripcion' => 'nullable|string',
            'orden' => 'required|integer|unique:niveles_entrenamiento,orden',
        ]);

        NivelesEntrenamiento::create([
            'nivel' => $request->nivel,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('niveles_entrenamiento.index')
            ->with('success', 'Nivel de entrenamiento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nivel = NivelesEntrenamiento::findOrFail($id);
        return view('niveles_entrenamiento.show', compact('nivel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $nivel = NivelesEntrenamiento::findOrFail($id);
        return view('niveles_entrenamiento.edit', compact('nivel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nivel = NivelesEntrenamiento::findOrFail($id);

        $request->validate([
            'nivel' => 'required|string|max:50|unique:niveles_entrenamiento,nivel,' . $id,
            'descripcion' => 'nullable|string',
            'orden' => 'required|integer|unique:niveles_entrenamiento,orden,' . $id,
        ]);

        $nivel->update([
            'nivel' => $request->nivel,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('niveles_entrenamiento.index')
            ->with('success', 'Nivel de entrenamiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $nivel = NivelesEntrenamiento::findOrFail($id);
            $nivel->delete();

            return redirect()->route('niveles_entrenamiento.index')
                ->with('success', 'Nivel de entrenamiento eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('niveles_entrenamiento.index')
                ->with('error', 'Error al eliminar el nivel de entrenamiento. Puede estar en uso.');
        }
    }
}
