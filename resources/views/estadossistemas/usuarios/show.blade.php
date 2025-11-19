<x-layouts.crud>

    <x-slot name="title">Usuario Details</x-slot>

    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('.estadossistemas.index') }}">Estados Sistemas</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('.estadossistemas.show', $estadossistema) }}">{{ $estadossistema->name ?? $estadossistema->id }}</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('estadossistemas.usuarios.index', $estadossistema) }}">Usuarios</a>
        </li>
        <li class="breadcrumb-item active">{{ $usuario->name ?? $usuario->id }}</li>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-title text-lg">Usuario Details</div>
            <div class="card-tools mr-0">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('usuarios.edit', $usuario) }}">Edit Usuario</a>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-sm table-hover">
                <tr>
                    <td>Nombre</td>
                    <td>{{ $usuario->nombre }}</td>
                </tr>
                <tr>
                    <td>Apellido</td>
                    <td>{{ $usuario->apellido }}</td>
                </tr>
                <tr>
                    <td>Ci</td>
                    <td>{{ $usuario->ci }}</td>
                </tr>
                <tr>
                    <td>Fecha Nacimiento</td>
                    <td>{{ $usuario->fecha_nacimiento->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <td>Genero Id</td>
                    <td>{{ $usuario->genero->name ?? $usuario->genero->id }}</td>
                </tr>
                <tr>
                    <td>Telefono</td>
                    <td>{{ $usuario->telefono }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $usuario->email }}</td>
                </tr>
                <tr>
                    <td>Tipo Sangre Id</td>
                    <td>{{ $usuario->tiposSangre->name ?? $usuario->tiposSangre->id }}</td>
                </tr>
                <tr>
                    <td>Nivel Entrenamiento Id</td>
                    <td>{{ $usuario->nivelesEntrenamiento->name ?? $usuario->nivelesEntrenamiento->id }}</td>
                </tr>
                <tr>
                    <td>Entidad Perteneciente</td>
                    <td>{{ $usuario->entidad_perteneciente }}</td>
                </tr>
                <tr>
                    <td>Rol Id</td>
                    <td>{{ $usuario->role->name ?? $usuario->role->id }}</td>
                </tr>
                <tr>
                    <td>Debe Cambiar Password</td>
                    <td>{{ $usuario->debe_cambiar_password }}</td>
                </tr>
                <tr>
                    <td>Reset Token</td>
                    <td>{{ $usuario->reset_token }}</td>
                </tr>
                <tr>
                    <td>Reset Token Expires</td>
                    <td>{{ $usuario->reset_token_expires }}</td>
                </tr>
                <tr>
                    <td>Creado</td>
                    <td>{{ $usuario->creado }}</td>
                </tr>
                <tr>
                    <td>Actualizado</td>
                    <td>{{ $usuario->actualizado }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title text-lg">Delete Usuario</div>
            <div class="card-tools mr-0">
                <form id="delete-form" action="{{ route('usuarios.destroy', $usuario) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete()">Delete
                        Usuario</button>
                </form>

                @section('plugins.Sweetalert2', true)
                <script>
                    function confirmDelete() {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            console.log(result);
                            if (result.isConfirmed) {
                                document.getElementById('delete-form').submit();
                            }
                        })
                    }
                </script>
            </div>
        </div>
    </div>
</x-layouts.crud>
