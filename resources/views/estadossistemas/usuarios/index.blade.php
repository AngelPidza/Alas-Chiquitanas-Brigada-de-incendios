<x-layouts.crud>

<x-slot:title>Usuario List</x-slot>

<x-slot:breadcrumbs>
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Usuarios</li>
</x-slot>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <form action="{{ route('usuarios.index') }}" method="GET" class="form-inline input-group input-group-sm" autocomplete="off">
                <input type="text" name="q" class="form-control" placeholder="Search usuarios..." value="{{ request('q') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        @if(request('q'))
        <span class="card-title ml-3">
            <a href="{{route('usuarios.index')}}" class="badge-pill btn btn-sm btn-primary">{{ request('q') }} <span class="ml-1 badge badge-sm badge-light badge-pill"><i class="fas fa-times"></i></span></a>
        </span>
        @endif
        <div class="card-tools mr-0">
            <a class="btn btn-sm btn-outline-primary" href="{{route('usuarios.create')}}">Add Usuario</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-sm table-hover">
            <thead class="text-sm">
            <tr>
                <th class="">Nombre</th>
                    <th class="">Apellido</th>
                    <th class="">Ci</th>
                    <th class="">Fecha Nacimiento</th>
                    <th class="">Genero Id</th>
                    <th class="">Telefono</th>
                    <th class="">Email</th>
                    <th class="">Tipo Sangre Id</th>
                    <th class="">Nivel Entrenamiento Id</th>
                    <th class="">Entidad Perteneciente</th>
                    <th class="">Rol Id</th>
                    <th class="">Debe Cambiar Password</th>
                    <th class="">Reset Token</th>
                    <th class="">Reset Token Expires</th>
                    <th class="">Creado</th>
                    <th class="">Actualizado</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody class="text-sm">
            @forelse($usuarios as $usuario)
            <tr>
                <td class="">{{ $usuario->nombre }}</td>
                    <td class="">{{ $usuario->apellido }}</td>
                    <td class="">{{ $usuario->ci }}</td>
                    <td class="">{{ $usuario->fecha_nacimiento->format('Y-m-d') }}</td>
                    <td class="">{{ $usuario->genero->name ?? $usuario->genero->id }}</td>
                    <td class="">{{ $usuario->telefono }}</td>
                    <td class="">{{ $usuario->email }}</td>
                    <td class="">{{ $usuario->tiposSangre->name ?? $usuario->tiposSangre->id }}</td>
                    <td class="">{{ $usuario->nivelesEntrenamiento->name ?? $usuario->nivelesEntrenamiento->id }}</td>
                    <td class="">{{ $usuario->entidad_perteneciente }}</td>
                    <td class="">{{ $usuario->role->name ?? $usuario->role->id }}</td>
                    <td class="">{{ $usuario->debe_cambiar_password }}</td>
                    <td class="">{{ $usuario->reset_token }}</td>
                    <td class="">{{ $usuario->reset_token_expires }}</td>
                    <td class="">{{ $usuario->creado }}</td>
                    <td class="">{{ $usuario->actualizado }}</td>
                <td>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('usuarios.show', $usuario) }}" class="text-primary text-center pl-3"><i class="fas fa-eye"></i> View</a>
                        <a href="{{ route('usuarios.edit', $usuario) }}" class="text-primary text-center pl-3"><i class="fas fa-edit"></i> Edit</a>
                    </div>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="16" class="text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- // pagination --}}
<div class="row justify-content-center">
    {{ $usuarios->links('pagination::bootstrap-4') }}
</div>

</x-layouts.crud>
