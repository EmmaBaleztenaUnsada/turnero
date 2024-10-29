<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\TurnoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('menu');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/create', [PacienteController::class, 'create'])->name('pacientes.create');
    Route::post('/pacientes', [PacienteController::class, 'store'])->name('pacientes.store');
    Route::delete('/pacientes/{paciente}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');
    Route::get('/pacientes/{id}', [PacienteController::class, 'show'])->name('pacientes.show');
    Route::get('/pacientes/buscar/{nro_documento}', [PacienteController::class, 'buscar'])->name('pacientes.buscar');

    Route::get('/turnos', [TurnoController::class, 'index'])->name('turnos.index');
    Route::get('/turnos/create', [TurnoController::class, 'create'])->name('turnos.create');
    Route::post('/turnos', [TurnoController::class, 'store'])->name('turnos.store');
    Route::delete('/turnos/{turno}', [TurnoController::class, 'destroy'])->name('turnos.destroy');
    Route::post('/turnos/guardarPacienteTurno', [TurnoController::class, 'guardarPacienteTurno'])->name('turnos.guardarPacienteTurno');
    Route::post('/turnos/guardar', [TurnoController::class, 'guardar'])->name('turnos.guardar');

    Route::get('/turnos/prueba', [TurnoController::class, 'prueba'])->name('turnos.prueba');
    
    Route::get('/cargarcalendario', [TurnoController::class, 'cargarcalendario'])->name('turnos.cargarcalendario');
    

});

require __DIR__.'/auth.php';
