@extends('layouts.app')

@section('content')
<style>
    .custom-title {
        font-size: 3rem;
        color: #ff5733; /* Cambia este color según tu preferencia */
        font-weight: bold;
        text-align: center;
    }

    .card {
        border-radius: 1rem; /* Bordes redondeados */
    }

    .btn-custom {
        font-size: 1.2rem; /* Aumentar el tamaño de la fuente */
        padding: 10px 20px; /* Espaciado interno */
        border-radius: 0.5rem; /* Bordes redondeados */
        transition: background-color 0.3s; /* Transición suave al pasar el mouse */
        width: 100%; /* Botones de ancho completo */
        margin-bottom: 15px; /* Espaciado entre botones */
    }

    .btn-custom:hover {
        background-color: #e0e0e0; /* Color al pasar el mouse */
    }
</style>

<div class="container">
    <h1 class="mt-4 custom-title">Menú</h1>

    <div class="card mt-4 p-4">
        <div class="text-center">
            <a href="{{ route('pacientes.index') }}" class="btn btn-success btn-custom">Pacientes</a>
            <a href="{{ route('pacientes.create') }}" class="btn btn-primary btn-custom">Crear paciente</a>
            <a href="{{ route('turnos.create') }}" class="btn btn-warning btn-custom">Crear turno</a>
            <a href="{{ route('turnos.index') }}" class="btn btn-info btn-custom">Turnos</a>
        </div>
    </div>
</div>

<!-- <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                Contenido adicional si es necesario 
            </div>
        </div>
    </div>
</div> -->
@endsection
