<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use App\Models\TiposRecurso;
use App\Models\EstadosSistema;
use Illuminate\Http\Request;

class RecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recursos = Recurso::orderBy('creado', 'desc')->paginate(20);

        // Cargar relaciones manualmente para evitar problema de UUID
        $tiposRecurso = TiposRecurso::all()->keyBy('id');
        $estadosSistema = EstadosSistema::all()->keyBy('id');

        foreach ($recursos as $recurso) {
            if ($recurso->tipo_recurso_id && isset($tiposRecurso[$recurso->tipo_recurso_id])) {
                $recurso->setRelation('tipos_recurso', $tiposRecurso[$recurso->tipo_recurso_id]);
            }
            if ($recurso->estado_id && isset($estadosSistema[$recurso->estado_id])) {
                $recurso->setRelation('estados_sistema', $estadosSistema[$recurso->estado_id]);
            }
        }

        return view('recursos.index', compact('recursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
