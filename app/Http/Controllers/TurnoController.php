<?php

namespace App\Http\Controllers;
use App\Models\Turno; // Asegúrate de importar tu modelo
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function prueba()
    {
        //$pacientes = Paciente::where('estado', true)->get();
        $fechaManana = Carbon::now()->addDay();
        $fechaDosMeses = Carbon::now()->addMonths(2);

        $turnos = Turno::where('estado', 'libre')
                    ->whereBetween('fecha', [$fechaManana, $fechaDosMeses])
                    ->get();
        return view('turnos.prueba', compact('turnos')); // Vista para crear paciente
    }

    public function create()
    {
        $pacientes = Paciente::where('estado', true)->get();
        return view('turnos.create', compact('pacientes')); // Vista para crear paciente
    }

    public function store(Request $request)
    {
        // Validación y almacenamiento del paciente
        // ...
    }
  
    public function destroy(Turno $turno)
    {
        $turno = Turno::findOrFail($turno->id);
        $turno->estado='libre';
        $turno->paciente_id=null;
        $turno->motivo= null;
        $turno->save();
 

        return redirect()->route('turnos.index')->with('success', 'Turno eliminado correctamente.');
    }

    public function cargarcalendario()
    {
        $fechaInicio = Carbon::now(); // Fecha actual
        $fechaFin = $fechaInicio->copy()->addMonths(3); // Fecha tres meses adelante

        // Horario de trabajo
        $horaInicio = Carbon::createFromTime(8, 0); // 8:00 AM
        $horaFin = Carbon::createFromTime(20, 0); // 8:00 PM

        // Iterar sobre cada día entre la fecha de inicio y fin
        while ($fechaInicio->lessThanOrEqualTo($fechaFin)) {
            // Solo días de lunes a viernes
            if ($fechaInicio->isWeekday()) {
                // Generar turnos cada 40 minutos
                $hora = $horaInicio->copy();

                while ($hora->lessThanOrEqualTo($horaFin)) {
                    // Crear el turno
                    Turno::create([
                        'paciente_id' => 0,
                        'fecha' => $fechaInicio->toDateString(),
                        'hora' => $hora->toTimeString(),
                        'estado' => 'libre',
                    ]);
                    $hora->addMinutes(40); // Incrementar 40 minutos
                }
            }
            $fechaInicio->addDay(); // Pasar al siguiente día
        }

        return response()->json(['message' => 'Turnos cargados exitosamente.']);
    }
    
    public function guardarPacienteTurno(Request $request)
    {
        
        // Validar y guardar el paciente
        $paciente = Paciente::create($request->all());
        
        // Obtener los turnos del paciente recién guardado
        //$turnos = Turno::where('paciente_id', $paciente->id)->get();

        //obtener todos los turnos, deberia ser el libre mas reciente
        //$turnos = Turno::where('estado', 'libre')->get();

        $fechaManana = Carbon::now()->addDay();
        $fechaDosMeses = Carbon::now()->addMonths(2);

        $turnos = Turno::where('estado', 'libre')
                    ->whereBetween('fecha', [$fechaManana, $fechaDosMeses])
                    ->get();
        // Retornar los turnos en la respuesta
        return response()->json(['turnos' => $turnos, 'paciente_id' => $paciente->id]);
    }

    public function guardar(Request $request)
    {
        // Validar que el ID del turno y el ID del paciente existan en la solicitud
        $request->validate([
            'turno_id' => 'required|exists:turnos,id',
            'paciente_id' => 'required|exists:pacientes,id'
        ]);

        // Obtener los datos de la solicitud
        $turnoId = $request->input('turno_id');
        $pacienteId = $request->input('paciente_id');

        // Buscar el turno por ID
        $turno = Turno::find($turnoId);

        // Verificar que el turno está disponible (estado 'libre')
        if ($turno->estado !== 'libre') {
            return response()->json([
                'message' => 'Este turno ya ha sido reservado por otro paciente.'
            ], 400);
        }

        // Asignar el ID del paciente y cambiar el estado a 'ocupado'
        $turno->paciente_id = $pacienteId;
        $turno->estado = 'ocupado';
        $turno->motivo = $request->input('motivo');

        // Guardar los cambios en la base de datos
        $turno->save();

        return response()->json([
            'message' => 'Turno reservado exitosamente.',
            'turno' => $turno
        ], 200);
    } 

    public function index()
    {
        //$turnos = Turno::where('estado', 'ocupado')->get();
        $turnos = Turno::where('estado', 'ocupado')
            ->with('paciente') // Cargar la relación
            ->get();

        //dd($turnos);    
        return view('turnos.index', compact('turnos'));
    }
}
