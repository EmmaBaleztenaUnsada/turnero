@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Pacientes</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('pacientes.create') }}" class="btn btn-primary mb-3">Crear Paciente</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Nro documento</th>
                <th>Telefono</th>
                <th>Obra social</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $paciente)
                <tr>
                    <td>{{ $paciente->nombre }}</td>
                    <td>{{ $paciente->apellido }}</td>
                    <td>{{ $paciente->nro_documento }}</td>
                    <td>{{ $paciente->telefono }}</td>
                    <td>{{ $paciente->obra_social }}</td>
                    <td>
                        <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
