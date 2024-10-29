@extends('layouts.app')

@section('content')
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- {{ __("¡Estás Logueado!") }} -->
                    
                    <div class="mt-4">
                        <a href="{{ route('pacientes.index') }}" class="btn btn-success">Pacientes</a>
                        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">Crear paciente</a>
                        <a href="{{ route('turnos.create') }}" class="btn btn-success">Crear turno</a>
                        <a href="{{ route('turnos.index') }}" class="btn btn-primary">Turnos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
