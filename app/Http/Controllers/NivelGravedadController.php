<?php

namespace App\Http\Controllers;

use App\Models\NivelesGravedad;
use Illuminate\Http\Request;

class NivelGravedadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $niveles = NivelesGravedad::orderBy('orden')->get();
        return view('niveles_gravedad.index', compact('niveles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('niveles_gravedad.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:20|unique:niveles_gravedad,codigo',
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'orden' => 'nullable|integer|unique:niveles_gravedad,orden',
            'color' => 'nullable|string|max:7',
        ]);

        NivelesGravedad::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden,
            'color' => $request->color,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('niveles_gravedad.index')
            ->with('success', 'Nivel de gravedad creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nivel = NivelesGravedad::findOrFail($id);
        return view('niveles_gravedad.show', compact('nivel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $nivel = NivelesGravedad::findOrFail($id);
        return view('niveles_gravedad.edit', compact('nivel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nivel = NivelesGravedad::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|max:20|unique:niveles_gravedad,codigo,' . $id,
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'orden' => 'nullable|integer|unique:niveles_gravedad,orden,' . $id,
            'color' => 'nullable|string|max:7',
        ]);

        $nivel->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden,
            'color' => $request->color,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('niveles_gravedad.index')
            ->with('success', 'Nivel de gravedad actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $nivel = NivelesGravedad::findOrFail($id);
            $nivel->delete();

            return redirect()->route('niveles_gravedad.index')
                ->with('success', 'Nivel de gravedad eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('niveles_gravedad.index')
                ->with('error', 'Error al eliminar el nivel de gravedad. Puede estar en uso.');
        }
    }
}
