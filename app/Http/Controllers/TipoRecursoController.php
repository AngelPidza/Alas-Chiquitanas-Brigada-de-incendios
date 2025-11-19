<?php

namespace App\Http\Controllers;

use App\Models\TiposRecurso;
use Illuminate\Http\Request;

class TipoRecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TiposRecurso::orderBy('categoria')->orderBy('codigo')->get();
        return view('tipos_recurso.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipos_recurso.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:tipos_recurso,codigo',
            'nombre' => 'required|string|max:100',
            'categoria' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'nullable|string|max:50',
        ]);

        TiposRecurso::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'unidad_medida' => $request->unidad_medida,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('tipos_recurso.index')
            ->with('success', 'Tipo de recurso creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tipo = TiposRecurso::findOrFail($id);
        return view('tipos_recurso.show', compact('tipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tipo = TiposRecurso::findOrFail($id);
        return view('tipos_recurso.edit', compact('tipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tipo = TiposRecurso::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|max:50|unique:tipos_recurso,codigo,' . $id,
            'nombre' => 'required|string|max:100',
            'categoria' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'nullable|string|max:50',
        ]);

        $tipo->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'unidad_medida' => $request->unidad_medida,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('tipos_recurso.index')
            ->with('success', 'Tipo de recurso actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tipo = TiposRecurso::findOrFail($id);
            $tipo->delete();

            return redirect()->route('tipos_recurso.index')
                ->with('success', 'Tipo de recurso eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('tipos_recurso.index')
                ->with('error', 'Error al eliminar el tipo de recurso. Puede estar en uso.');
        }
    }
}
