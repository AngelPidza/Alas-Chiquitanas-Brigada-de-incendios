<?php

namespace App\Http\Controllers;

use App\Models\TiposSangre;
use Illuminate\Http\Request;

class TipoSangreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tiposSangre = TiposSangre::orderBy('codigo')->get();
        return view('tipos_sangre.index', compact('tiposSangre'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipos_sangre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:5|unique:tipos_sangre,codigo',
            'descripcion' => 'nullable|string|max:50',
        ]);

        TiposSangre::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('tipos_sangre.index')
            ->with('success', 'Tipo de sangre creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tipoSangre = TiposSangre::findOrFail($id);
        return view('tipos_sangre.show', compact('tipoSangre'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tipoSangre = TiposSangre::findOrFail($id);
        return view('tipos_sangre.edit', compact('tipoSangre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tipoSangre = TiposSangre::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|max:5|unique:tipos_sangre,codigo,' . $id,
            'descripcion' => 'nullable|string|max:50',
        ]);

        $tipoSangre->update([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('tipos_sangre.index')
            ->with('success', 'Tipo de sangre actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tipoSangre = TiposSangre::findOrFail($id);
            $tipoSangre->delete();

            return redirect()->route('tipos_sangre.index')
                ->with('success', 'Tipo de sangre eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('tipos_sangre.index')
                ->with('error', 'Error al eliminar el tipo de sangre. Puede estar en uso.');
        }
    }
}
