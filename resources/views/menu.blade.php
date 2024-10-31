@extends('layouts.app')

@section('content')
<style>
    .custom-title {
        font-size: 3rem;
        color: #000000; /* Título en negro */
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
        transition: background-color 0.3s, transform 0.3s; /* Transición suave al pasar el mouse */
        width: 100%; /* Botones de ancho completo */
        margin-bottom: 15px; /* Espaciado entre botones */
        font-weight: bold; /* Negrita para los botones */
    }

    .btn-success {
        background-color: #28a745; /* Verde */
        border-color: #28a745; /* Bordes del botón */
    }
    
    .btn-primary {
        background-color: #007bff; /* Azul */
        border-color: #007bff; /* Bordes del botón */
    }

    .btn-warning {
        background-color: #ffc107; /* Amarillo */
        border-color: #ffc107; /* Bordes del botón */
    }

    .btn-info {
        background-color: #17a2b8; /* Cian */
        border-color: #17a2b8; /* Bordes del botón */
    }

    /* Colores para el hover */
    .btn-custom:hover {
        background-color: #e0e0e0; /* Color al pasar el mouse */
        transform: scale(1.05); /* Efecto de aumento */
    }
</style>

<div class="container">
    <h1 class="mt-4 custom-title">Menú</h1>

    <div class="card mt-4 p-4">
        <div class="text-center">
            <a href="{{ route('pacientes.index') }}" class="btn btn-success btn-custom">Pacientes</a>
            <a href="{{ route('pacientes.create') }}" class="btn btn-primary btn-custom">Crear paciente</a>
            <a href="{{ route('turnos.create') }}" class="btn btn-info btn-custom">Crear turno</a>
            <a href="{{ route('turnos.index') }}" class="btn btn-warning btn-custom">Turnos</a>
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
