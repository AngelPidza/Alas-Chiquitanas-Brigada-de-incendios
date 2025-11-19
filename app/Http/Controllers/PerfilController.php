<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    /**
     * Display the user's profile
     */
    public function index()
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        // Cargar relaciones manualmente para evitar problemas con UUID
        $generos = \App\Models\Genero::all()->keyBy('id');
        $tiposSangre = \App\Models\TiposSangre::all()->keyBy('id');
        $nivelesEntrenamiento = \App\Models\NivelesEntrenamiento::all()->keyBy('id');
        $roles = \App\Models\Role::all()->keyBy('id');
        $estados = \App\Models\EstadosSistema::all()->keyBy('id');

        // Asociar relaciones manualmente
        if ($usuario->genero_id && isset($generos[$usuario->genero_id])) {

            $usuario->setRelation('genero', $generos[$usuario->genero_id]);
        }
        if ($usuario->tipo_sangre_id && isset($tiposSangre[$usuario->tipo_sangre_id])) {
            $usuario->setRelation('tipos_sangre', $tiposSangre[$usuario->tipo_sangre_id]);
        }
        if ($usuario->nivel_entrenamiento_id && isset($nivelesEntrenamiento[$usuario->nivel_entrenamiento_id])) {
            $usuario->setRelation('niveles_entrenamiento', $nivelesEntrenamiento[$usuario->nivel_entrenamiento_id]);
        }
        if ($usuario->rol_id && isset($roles[$usuario->rol_id])) {
            $usuario->setRelation('role', $roles[$usuario->rol_id]);
        }
        if ($usuario->estado_id && isset($estados[$usuario->estado_id])) {
            $usuario->setRelation('estados_sistema', $estados[$usuario->estado_id]);
        }

        return view('perfil.index', compact('usuario', 'generos', 'tiposSangre', 'nivelesEntrenamiento', 'roles', 'estados'));
    }

    /**
     * Update user profile information
     */
    public function update(Request $request)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('usuarios', 'email')->ignore($usuario->id),
            ],
            'telefono' => 'nullable|string|max:20',
            'genero_id' => 'nullable|uuid|exists:generos,id',
            'tipo_sangre_id' => 'nullable|uuid|exists:tipos_sangre,id',
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'genero_id' => $request->genero_id,
            'tipo_sangre_id' => $request->tipo_sangre_id,
        ]);

        return redirect()->route('perfil')
            ->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Show change password form
     */
    public function cambiarPassword()
    {
        return view('perfil.cambiar-password');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_actual' => 'required|string',
            'password_nueva' => 'required|string|min:8|confirmed',
        ], [
            'password_actual.required' => 'La contraseña actual es requerida.',
            'password_nueva.required' => 'La nueva contraseña es requerida.',
            'password_nueva.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password_nueva.confirmed' => 'Las contraseñas no coinciden.',
        ]);
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($request->password_actual, $usuario->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar contraseña
        $usuario->update([
            'password' => Hash::make($request->password_nueva),
        ]);

        return redirect()->route('perfil')
            ->with('success', 'Contraseña actualizada exitosamente.');
    }
}
