<x-layouts.crud>

<x-slot name="title">{{ $estado_sistema ? 'Update EstadSistema' : 'Create EstadSistema' }}</x-slot>

<x-slot name="breadcrumbs">
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{route('estado_sistemas.index')}}">Estad Sistemas</a></li>
    @isset($estado_sistema)
        <li class="breadcrumb-item"><a href="{{route('estado_sistemas.show', $estado_sistema)}}">{{ $estado_sistema->name ?? $estado_sistema->id }}</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @else
        <li class="breadcrumb-item active">Create</li>
    @endisset
</x-slot>

<div class="card">
    <div class="card-header">
        <div class="card-title text-lg">{{ $estado_sistema ? 'Edit EstadSistema' : 'Create EstadSistema' }}</div>
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

        <form id="crud-edit" method="post" class="needs-validation" novalidate autocomplete="off" action="{{ $action }}">
            @if ($estado_sistema) @method('PUT') @endif
            @csrf
            <input type="hidden" name="_referrer" value="{{ old('_referrer', $referrer) }}">
            <x-crud.model class="row" :model="$estado_sistema">
            <x-crud.group id="tabla" label="Tabla" class="col-sm-6 col-lg-3">
                    <x-crud.input type="text" name="tabla" required/>
                </x-crud.group>

                <x-crud.group id="codigo" label="Codigo" class="col-sm-6 col-lg-3">
                    <x-crud.input type="text" name="codigo" required/>
                </x-crud.group>

                <x-crud.group id="nombre" label="Nombre" class="col-sm-6 col-lg-3">
                    <x-crud.input type="text" name="nombre" required/>
                </x-crud.group>

                <x-crud.group id="descripcion" label="Descripcion" class="col-sm-6 col-lg-3">
                    <x-crud.textarea name="descripcion" rows="5"/>
                </x-crud.group>

                <x-crud.group id="color" label="Color" class="col-sm-6 col-lg-3">
                    <x-crud.input type="text" name="color"/>
                </x-crud.group>

                <x-crud.group id="es_final" label="Es Final" class="col-sm-6 col-lg-3">
                    <x-crud.input type="text" name="es_final"/>
                </x-crud.group>

                <x-crud.group id="orden" label="Orden" class="col-sm-6 col-lg-3">
                    <x-crud.input type="text" name="orden"/>
                </x-crud.group>

                <x-crud.group id="activo" label="Activo" class="col-sm-6 col-lg-3">
                    <x-crud.input type="text" name="activo"/>
                </x-crud.group>

                <x-crud.group id="creado" label="Creado" class="col-sm-6 col-lg-3">
                    <x-crud.input type="datetime-local" step="1" name="creado"/>
                </x-crud.group>
        </x-crud.model>
        </form>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-4">
                <a class="btn btn-link pl-0" href="{{ $referrer ?? route('estado_sistemas.index') }}">&laquo; Back</a>
            </div>
            <div class="col-sm-4 text-center">
            </div>
            <div class="col-sm-4 text-right">
                <button type="submit" form="crud-edit" class="btn btn-info">{{ $estado_sistema ? 'Update EstadSistema' : 'Create EstadSistema' }}</button>
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