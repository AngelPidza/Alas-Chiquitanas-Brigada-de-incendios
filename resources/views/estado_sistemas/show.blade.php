<x-layouts.crud>

<x-slot name="title">EstadSistema Details</x-slot>

<x-slot name="breadcrumbs">
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{route('estado_sistemas.index')}}">Estad Sistemas</a></li>
    <li class="breadcrumb-item active">{{ $estado_sistema->name ?? $estado_sistema->id }}</li>
</x-slot>

<div class="card">
    <div class="card-header">
        <div class="card-title text-lg">EstadSistema Details</div>
        <div class="card-tools mr-0">
            <a class="btn btn-sm btn-outline-primary" href="{{route('estado_sistemas.edit', $estado_sistema)}}">Edit EstadSistema</a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-sm table-hover">
            <tr>
                    <td>Tabla</td>
                    <td>{{ $estado_sistema->tabla }}</td>
                </tr>
                <tr>
                    <td>Codigo</td>
                    <td>{{ $estado_sistema->codigo }}</td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td>{{ $estado_sistema->nombre }}</td>
                </tr>
                <tr>
                    <td>Descripcion</td>
                    <td>{{ $estado_sistema->descripcion }}</td>
                </tr>
                <tr>
                    <td>Color</td>
                    <td>{{ $estado_sistema->color }}</td>
                </tr>
                <tr>
                    <td>Es Final</td>
                    <td>{{ $estado_sistema->es_final }}</td>
                </tr>
                <tr>
                    <td>Orden</td>
                    <td>{{ $estado_sistema->orden }}</td>
                </tr>
                <tr>
                    <td>Activo</td>
                    <td>{{ $estado_sistema->activo }}</td>
                </tr>
                <tr>
                    <td>Creado</td>
                    <td>{{ $estado_sistema->creado }}</td>
                </tr>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title text-lg">Delete EstadSistema</div>
        <div class="card-tools mr-0">
        <form id="delete-form" action="{{route('estado_sistemas.destroy', $estado_sistema)}}" method="POST" >
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete()">Delete EstadSistema</button>
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
