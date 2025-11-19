<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Usuario;
use App\Models\EstadosSistema;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipos = Equipo::orderBy('creado', 'desc')->paginate(20);

        // Cargar relaciones manualmente para evitar problema de UUID
        $estadosSistema = EstadosSistema::all()->keyBy('id');

        foreach ($equipos as $equipo) {
            if ($equipo->estado_id && isset($estadosSistema[$equipo->estado_id])) {
                $equipo->setRelation('estados_sistema', $estadosSistema[$equipo->estado_id]);
            }
        }

        return view('equipos.index', compact('equipos'));
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
