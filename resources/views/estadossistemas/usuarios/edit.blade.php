<x-layouts.crud>

    <x-slot name="title">{{ $usuario ? 'Update Usuario' : 'Create Usuario' }}</x-slot>

    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('.estadossistemas.index') }}">Estados Sistemas</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('.estadossistemas.show', $estadossistema) }}">{{ $estadossistema->name ?? $estadossistema->id }}</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('estadossistemas.usuarios.index', $estadossistema) }}">Usuarios</a>
        </li>
        @isset($usuario)
            <li class="breadcrumb-item"><a
                    href="{{ route('usuarios.show', $usuario) }}">{{ $usuario->name ?? $usuario->id }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        @else
            <li class="breadcrumb-item active">Create</li>
        @endisset
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-title text-lg">{{ $usuario ? 'Edit Usuario' : 'Create Usuario' }}</div>
            <div class="card-tools mr-0">
                <button type="reset" form="crud-edit" class="btn btn-sm btn-outline-warning">Reset</button>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-warning">
                    <ul class="py-0 my-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="crud-edit" method="post" class="needs-validation" novalidate autocomplete="off"
                action="{{ $action }}">
                @if ($usuario)
                    @method('PUT')
                @endif
                @csrf
                <input type="hidden" name="_referrer" value="{{ old('_referrer', $referrer) }}">
                <x-crud.model class="row" :model="$usuario">
                    <x-crud.group id="nombre" label="Nombre" class="col-sm-6 col-lg-3">
                        <x-crud.input type="text" name="nombre" required />
                    </x-crud.group>

                    <x-crud.group id="apellido" label="Apellido" class="col-sm-6 col-lg-3">
                        <x-crud.input type="text" name="apellido" required />
                    </x-crud.group>

                    <x-crud.group id="ci" label="Ci" class="col-sm-6 col-lg-3">
                        <x-crud.input type="text" name="ci" required />
                    </x-crud.group>

                    <x-crud.group id="fecha_nacimiento" label="Fecha Nacimiento" class="col-sm-6 col-lg-3">
                        <x-crud.input type="date" name="fecha_nacimiento" required />
                    </x-crud.group>

                    <x-crud.group id="genero_id" label="Genero Id" class="col-sm-6 col-lg-3">
                        <x-crud.choices type="select" name="genero_id" :options="App\Models\Genero::all()" />
                    </x-crud.group>

                    <x-crud.group id="telefono" label="Telefono" class="col-sm-6 col-lg-3">
                        <x-crud.input type="text" name="telefono" />
                    </x-crud.group>

                    <x-crud.group id="email" label="Email" class="col-sm-6 col-lg-3">
                        <x-crud.input type="email" name="email" required />
                    </x-crud.group>

                    <x-crud.group id="tipo_sangre_id" label="Tipo Sangre Id" class="col-sm-6 col-lg-3">
                        <x-crud.choices type="select" name="tipo_sangre_id" :options="App\Models\TiposSangre::all()" />
                    </x-crud.group>

                    <x-crud.group id="nivel_entrenamiento_id" label="Nivel Entrenamiento Id" class="col-sm-6 col-lg-3">
                        <x-crud.choices type="select" name="nivel_entrenamiento_id" :options="App\Models\NivelesEntrenamiento::all()" />
                    </x-crud.group>

                    <x-crud.group id="entidad_perteneciente" label="Entidad Perteneciente" class="col-sm-6 col-lg-3">
                        <x-crud.input type="text" name="entidad_perteneciente" />
                    </x-crud.group>

                    <x-crud.group id="rol_id" label="Rol Id" class="col-sm-6 col-lg-3">
                        <x-crud.choices type="select" name="rol_id" :options="App\Models\Role::all()" />
                    </x-crud.group>

                    <x-crud.group id="debe_cambiar_password" label="Debe Cambiar Password" class="col-sm-6 col-lg-3">
                        <x-crud.input type="text" name="debe_cambiar_password" />
                    </x-crud.group>

                    <x-crud.group id="reset_token" label="Reset Token" class="col-sm-6 col-lg-3">
                        <x-crud.input type="text" name="reset_token" />
                    </x-crud.group>

                    <x-crud.group id="reset_token_expires" label="Reset Token Expires" class="col-sm-6 col-lg-3">
                        <x-crud.input type="datetime-local" step="1" name="reset_token_expires" />
                    </x-crud.group>

                    <x-crud.group id="creado" label="Creado" class="col-sm-6 col-lg-3">
                        <x-crud.input type="datetime-local" step="1" name="creado" />
                    </x-crud.group>

                    <x-crud.group id="actualizado" label="Actualizado" class="col-sm-6 col-lg-3">
                        <x-crud.input type="datetime-local" step="1" name="actualizado" />
                    </x-crud.group>
                </x-crud.model>
            </form>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-4">
                    <a class="btn btn-link pl-0"
                        href="{{ $referrer ?? route('estadossistemas.usuarios.index') }}">&laquo; Back</a>
                </div>
                <div class="col-sm-4 text-center">
                </div>
                <div class="col-sm-4 text-right">
                    <button type="submit" form="crud-edit"
                        class="btn btn-info">{{ $usuario ? 'Update Usuario' : 'Create Usuario' }}</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('js/crud-edit.js') }}"></script>
        <script>
            trackFormModification("crud-edit");
        </script>
    @endpush

</x-layouts.crud>
