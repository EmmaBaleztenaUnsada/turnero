@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Turnos</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('turnos.create') }}" class="btn btn-primary mb-3">Crear Turno</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Motivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($turnos as $turno)
                <tr>
                    <td>{{ $turno->paciente->nombre }} {{ $turno->paciente->apellido }}</td>
                    <td>{{ $turno->fecha }}</td>
                    <td>{{ $turno->hora }}</td>
                    <td>{{ $turno->estado }}</td>
                    <td>{{ $turno->motivo }}</td>
                    <td>
                        <form action="{{ route('turnos.destroy', $turno->id) }}" method="POST">
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
