<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $generos = Genero::orderBy('codigo')->get();
        return view('generos.index', compact('generos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('generos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:20|unique:generos,codigo',
            'descripcion' => 'nullable|string|max:50',
        ]);

        Genero::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('generos.index')
            ->with('success', 'Género creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genero = Genero::findOrFail($id);
        return view('generos.show', compact('genero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $genero = Genero::findOrFail($id);
        return view('generos.edit', compact('genero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $genero = Genero::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|max:20|unique:generos,codigo,' . $id,
            'descripcion' => 'nullable|string|max:50',
        ]);

        $genero->update([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('generos.index')
            ->with('success', 'Género actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $genero = Genero::findOrFail($id);
            $genero->delete();

            return redirect()->route('generos.index')
                ->with('success', 'Género eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('generos.index')
                ->with('error', 'Error al eliminar el género. Puede estar en uso.');
        }
    }
}
