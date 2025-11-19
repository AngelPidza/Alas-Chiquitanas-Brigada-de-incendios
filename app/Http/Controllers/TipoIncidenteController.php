<?php

namespace App\Http\Controllers;

use App\Models\TiposIncidente;
use Illuminate\Http\Request;

class TipoIncidenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TiposIncidente::orderBy('codigo')->get();
        return view('tipos_incidente.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipos_incidente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:tipos_incidente,codigo',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icono' => 'nullable|string|max:50',
        ]);

        TiposIncidente::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'color' => $request->color,
            'icono' => $request->icono,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('tipos_incidente.index')
            ->with('success', 'Tipo de incidente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tipo = TiposIncidente::findOrFail($id);
        return view('tipos_incidente.show', compact('tipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tipo = TiposIncidente::findOrFail($id);
        return view('tipos_incidente.edit', compact('tipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tipo = TiposIncidente::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|max:50|unique:tipos_incidente,codigo,' . $id,
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icono' => 'nullable|string|max:50',
        ]);

        $tipo->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'color' => $request->color,
            'icono' => $request->icono,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('tipos_incidente.index')
            ->with('success', 'Tipo de incidente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tipo = TiposIncidente::findOrFail($id);
            $tipo->delete();

            return redirect()->route('tipos_incidente.index')
                ->with('success', 'Tipo de incidente eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('tipos_incidente.index')
                ->with('error', 'Error al eliminar el tipo de incidente. Puede estar en uso.');
        }
    }
}
