<?php

namespace App\Http\Controllers;

use App\Models\EstadosSistema;
use Illuminate\Http\Request;

class EstadoSistemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = EstadosSistema::orderBy('tabla')->orderBy('orden')->get();
        return view('estados_sistema.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estados_sistema.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tabla' => 'required|string|max:50',
            'codigo' => 'required|string|max:50',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'es_final' => 'nullable|boolean',
            'orden' => 'nullable|integer',
        ]);

        // Check unique constraint for tabla + codigo combination
        $exists = EstadosSistema::where('tabla', $request->tabla)
            ->where('codigo', $request->codigo)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['codigo' => 'La combinación de tabla y código ya existe.']);
        }

        EstadosSistema::create([
            'tabla' => $request->tabla,
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'color' => $request->color,
            'es_final' => $request->has('es_final'),
            'orden' => $request->orden,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('estados-sistema.index')
            ->with('success', 'Estado del sistema creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estado = EstadosSistema::findOrFail($id);
        return view('estados_sistema.show', compact('estado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $estado = EstadosSistema::findOrFail($id);
        return view('estados_sistema.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $estado = EstadosSistema::findOrFail($id);

        $request->validate([
            'tabla' => 'required|string|max:50',
            'codigo' => 'required|string|max:50',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'es_final' => 'nullable|boolean',
            'orden' => 'nullable|integer',
        ]);

        // Check unique constraint for tabla + codigo combination (excluding current record)
        $exists = EstadosSistema::where('tabla', $request->tabla)
            ->where('codigo', $request->codigo)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['codigo' => 'La combinación de tabla y código ya existe.']);
        }

        $estado->update([
            'tabla' => $request->tabla,
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'color' => $request->color,
            'es_final' => $request->has('es_final'),
            'orden' => $request->orden,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('estados-sistema.index')
            ->with('success', 'Estado del sistema actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $estado = EstadosSistema::findOrFail($id);
            $estado->delete();

            return redirect()->route('estados-sistema.index')
                ->with('success', 'Estado del sistema eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('estados-sistema.index')
                ->with('error', 'Error al eliminar el estado del sistema. Puede estar en uso.');
        }
    }
}
