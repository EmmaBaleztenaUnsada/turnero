<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Turno;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PacienteController extends Controller
{
     // Muestra todos los pacientes
     public function index()
     {
         $pacientes = Paciente::where('estado', true)->get();
         return view('pacientes.index', compact('pacientes'));
     }
 
     // Muestra el formulario de creación
     public function create()
     {
         return view('pacientes.create');
     }
 
     // Almacena un nuevo paciente en la base de datos
     public function store(Request $request)
     {
         // Validación de los datos
         $request->validate([
             'nombre' => 'required|string|max:255',
             'apellido' => 'required|string|max:255',
             'nro_documento' => 'required|string|max:255',
         ]);
 
         // Creación del paciente
         Paciente::create($request->all());
 
         return redirect()->route('pacientes.index')
                          ->with('success', 'Paciente creado correctamente.');
     }
 
     // Elimina un paciente
     public function destroy(Paciente $paciente)
     {
        $paciente = Paciente::findOrFail($paciente->id);
        $paciente->estado=false;
        $paciente->save();
 
        return redirect()->route('pacientes.index')
                          ->with('success', 'Paciente eliminado correctamente.');
     }

    public function show($id)
    {
        $paciente = Paciente::find($id);
        if (!$paciente) {
            return response()->json(['error' => 'Paciente no encontrado'], 404);
        }
        return response()->json($paciente);
    }

    public function buscar($nro_documento)
    {
        $paciente = Paciente::where('nro_documento', $nro_documento)->first();

        if ($paciente) {
            $fechaManana = Carbon::now()->addDay();
            $fechaDosMeses = Carbon::now()->addMonths(2);
    
            $turnos = Turno::where('estado', 'libre')
                        ->whereBetween('fecha', [$fechaManana, $fechaDosMeses])
                        ->get();
            // Retornar los turnos en la respuesta
            return response()->json(['turnos' => $turnos, 'paciente' => $paciente]);
        }
        
        //return json_encode($data, JSON_UNESCAPED_UNICODE);
        return response()->json(null); // Si no se encuentra el paciente
    }
   
}
