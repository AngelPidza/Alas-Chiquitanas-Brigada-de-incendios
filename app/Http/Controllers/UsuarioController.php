<?php

/** @noinspection PhpMissingReturnTypeInspection */

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\EstadosSistema;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request, EstadosSistema $estadossistema)
    {
        if ($term = $request->q) {
            $usuarios = $estadossistema->usuarios()->where('name', 'like', "%$term%")->paginate();
        } else {
            $usuarios = $estadossistema->usuarios()->paginate();
        }
        return view('estadossistemas.usuarios.index', compact('estadossistema', 'usuarios'));
    }

    public function create(EstadosSistema $estadossistema)
    {
        $usuario = null;
        $action = route('estadossistemas.usuarios.store', $estadossistema);
        $referrer = request()->headers->get('referer');

        return view('estadossistemas.usuarios.edit', compact('usuario', 'estadossistema', 'action', 'referrer'));
    }

    public function store(UsuarioRequest $request, EstadosSistema $estadossistema)
    {
        $fields = $request->validated();
        $estadossistema->usuarios()->create($fields);

        $referrer = $request->get('_referrer');
        $redirectTo = $referrer ?: route('estadossistemas.usuarios.index', $estadossistema);
        return redirect($redirectTo)->with('success', 'Usuario created successfully');
    }

    public function show(Usuario $usuario)
    {
        $estadossistema = $usuario->estadossistema;
        return view('estadossistemas.usuarios.show', compact('usuario', 'estadossistema'));
    }

    public function edit(Usuario $usuario)
    {
        $estadossistema = $usuario->estadossistema;
        $action = route('usuarios.update', $usuario);
        $referrer = request()->headers->get('referer');
        return view('estadossistemas.usuarios.edit', compact('usuario', 'estadossistema', 'action', 'referrer'));
    }

    public function update(UsuarioRequest $request, Usuario $usuario)
    {
        $fields = $request->validated();
        $usuario->update($fields);

        $referrer = $request->get('_referrer');
        $redirectTo = $referrer ?: route('estadossistemas.usuarios.index');
        return redirect($redirectTo)->with('success', 'Usuario updated successfully');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('estadossistemas.usuarios.index')->with('success', 'Usuario deleted successfully');
    }
}
