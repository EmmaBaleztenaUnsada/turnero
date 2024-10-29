@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Paciente</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pacientes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" class="form-control" id="apellido" value="{{ old('apellido') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" >
        </div>
        <div class="mb-3">
            <label for="nro_documento" class="form-label">Nro documento</label>
            <input type="text" name="nro_documento" class="form-control" id="nro_documento" value="{{ old('nro_documento') }}" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Telefono</label>
            <input type="number" name="telefono" class="form-control" id="telefono" value="{{ old('telefono') }}" min="1000000000" max="9999999999">
        </div>
        <div class="mb-3">
            <label for="obra_social" class="form-label">Obra social</label>
            <input type="text" name="obra_social" class="form-control" id="obra_social" value="{{ old('obra_social') }}">
        </div>

        <!-- ESTADO ACTIVO -->
        <div class="mb-3" style="display: none;">
            <input type="text" name="estado" class="form-control" id="estado" value=1>
        </div>
        <button type="submit" class="btn btn-primary">Crear Paciente</button>
    </form>
</div>
@endsection
