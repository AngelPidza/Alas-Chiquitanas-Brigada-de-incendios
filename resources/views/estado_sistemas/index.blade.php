<x-layouts.crud>

<x-slot:title>EstadSistema List</x-slot>

<x-slot:breadcrumbs>
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Estad Sistemas</li>
</x-slot>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <form action="{{ route('estado_sistemas.index') }}" method="GET" class="form-inline input-group input-group-sm" autocomplete="off">
                <input type="text" name="q" class="form-control" placeholder="Search estad sistemas..." value="{{ request('q') }}" required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        @if(request('q'))
        <span class="card-title ml-3">
            <a href="{{route('estado_sistemas.index')}}" class="badge-pill btn btn-sm btn-primary">{{ request('q') }} <span class="ml-1 badge badge-sm badge-light badge-pill"><i class="fas fa-times"></i></span></a>
        </span>
        @endif
        <div class="card-tools mr-0">
            <a class="btn btn-sm btn-outline-primary" href="{{route('estado_sistemas.create')}}">Add EstadSistema</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-sm table-hover">
            <thead class="text-sm">
            <tr>
                <th class="">Tabla</th>
                    <th class="">Codigo</th>
                    <th class="">Nombre</th>
                    <th class="">Descripcion</th>
                    <th class="">Color</th>
                    <th class="">Es Final</th>
                    <th class="">Orden</th>
                    <th class="">Activo</th>
                    <th class="">Creado</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody class="text-sm">
            @forelse($estado_sistemas as $estado_sistema)
            <tr>
                <td class="">{{ $estado_sistema->tabla }}</td>
                    <td class="">{{ $estado_sistema->codigo }}</td>
                    <td class="">{{ $estado_sistema->nombre }}</td>
                    <td class="">{{ $estado_sistema->descripcion }}</td>
                    <td class="">{{ $estado_sistema->color }}</td>
                    <td class="">{{ $estado_sistema->es_final }}</td>
                    <td class="">{{ $estado_sistema->orden }}</td>
                    <td class="">{{ $estado_sistema->activo }}</td>
                    <td class="">{{ $estado_sistema->creado }}</td>
                <td>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('estado_sistemas.show', $estado_sistema) }}" class="text-primary text-center pl-3"><i class="fas fa-eye"></i> View</a>
                        <a href="{{ route('estado_sistemas.edit', $estado_sistema) }}" class="text-primary text-center pl-3"><i class="fas fa-edit"></i> Edit</a>
                    </div>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- // pagination --}}
<div class="row justify-content-center">
    {{ $estado_sistemas->links('pagination::bootstrap-4') }}
</div>

</x-layouts.crud>
