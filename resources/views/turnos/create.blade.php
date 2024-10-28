@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<style>
        .calendar {
            width: 300px; /* Ajusta el ancho según sea necesario */
            margin: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }
        .calendar-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
        }
        .day {
            width: 14.28%; /* 100% dividido por 7 días */
            display: inline-block;
            text-align: center;
            padding: 10px 0;
            border: 1px solid #ccc;
        }
        .occupied {
            background-color: red; /* Días ocupados */
            color: white;
        }
        .available {
            background-color: green; /* Días libres */
            color: white;
        }
        .days-of-week {
            display: flex;
            justify-content: space-between;
            margin-bottom: -1px;
        }
        .empty {
            background-color: transparent; /* O color claro */
            border: none;
        }

</style>

    <div class="container">
        <h1 class="mt-4">Crear Turno</h1>

        <div id="mensaje"></div> <!-- Contenedor para mensajes -->

        <form id="pacienteForm" method="POST" action="{{ route('turnos.guardarPacienteTurno') }}" class="mt-4">
            @csrf

            <div class="mb-3">
                <label for="nro_documento" class="form-label">Nro Documento</label>
                <input type="text" name="nro_documento" class="form-control" id="nro_documento">
                <button type="button" id="buscarPaciente" class="btn btn-primary mt-2">Buscar Paciente</button>
            </div>

            <div id="datosPaciente" style="display: none;">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" readonly>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" id="apellido" readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" readonly>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" id="telefono" readonly>
                </div>
                <div class="mb-3">
                    <label for="obra_social" class="form-label">Obra social</label>
                    <input type="text" name="obra_social" class="form-control" id="obra_social" readonly>
                </div>
                <div class="hidden">
                    <input type="number" name="id_paciente" class="form-control" id="id_paciente" readonly>
                </div>
            </div>

            <div id="cargarPaciente" style="display: none;">
                <button type="button" id="nuevoPaciente" class="btn btn-secondary">Cargar Nuevo Paciente</button>
            </div>
        </form>


        <!-- CALENDARIO -->
        <div class="container mt-4" id="calendario" style="display: none;">
            <h3>Calendario de Turnos</h3>
            <div class="calendar-header d-flex justify-content-between align-items-center">
                <button id="prevMonth" class="btn btn-primary">&lt;</button>
                <h4 id="calendarMonth"></h4>
                <button id="nextMonth" class="btn btn-primary">&gt;</button>
            </div>
            <div class="row text-center font-weight-bold mt-2">
                <div class="col">Dom</div>
                <div class="col">Lun</div>
                <div class="col">Mar</div>
                <div class="col">Mié</div>
                <div class="col">Jue</div>
                <div class="col">Vie</div>
                <div class="col">Sáb</div>
            </div>
            <div id="calendarDays" class="row mt-2">
                <!-- Días generados dinámicamente -->
            </div>
            
            <!-- Contenedor para horarios disponibles -->
            <div id="horariosDisponibles" class="mt-4">
                <h5>Horarios Disponibles</h5>
                <ul id="listaHorarios"></ul>
            </div>
        </div>

<!-- Modal para seleccionar horarios -->
<div class="modal fade" id="horariosModal" tabindex="-1" aria-labelledby="horariosModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="horariosModalLabel">Selecciona un Horario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <!-- Campo oculto para almacenar el ID -->
                <!-- <input type="hidden" id="hiddenId" value=""> -->
                <input type="hidden" id="hiddenId" value="">
                <select id="selectHorarios" class="form-select">
                    <!-- Opciones de horarios se llenarán aquí -->
                </select>
                <!-- Campo de texto para el motivo -->
                <label for="motivo" class="form-label mt-3">Motivo del Turno</label>
                <textarea id="motivo" class="form-control" rows="3" placeholder="Escribe el motivo del turno aquí..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btnConfirmar" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>


</div>


<script>
    let currentDate = new Date();

    function renderCalendar() {
        const month = currentDate.getMonth();
        const year = currentDate.getFullYear();
        document.getElementById('calendarMonth').innerText = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;
        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const lastDayOfMonth = new Date(year, month + 1, 0).getDate();

        let daysHTML = '';
        for (let i = 0; i < firstDayOfMonth; i++) {
            daysHTML += '<div class="day"></div>'; // Espacios vacíos
        }
        for (let i = 1; i <= lastDayOfMonth; i++) {
            const occupied = Math.random() < 0.5; // Simulando si el día está ocupado
            //const className = occupied ? 'occupied' : 'available';
            const className = 'occupied';
            daysHTML += `<div class="day ${className}">${i}</div>`;
        }
        document.getElementById('calendarDays').innerHTML = daysHTML;
    }

    function generarCalendario(turnos) {
        $('#calendarDays').empty(); // Limpiar el contenedor de días
        $('#listaHorarios').empty(); // Limpiar lista de horarios

        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();
        const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0); // Último día del mes

        // Obtener el primer día del mes y su índice
        const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
        const firstDayIndex = firstDayOfMonth.getDay();

        // Agregar celdas vacías
        for (let i = 0; i < firstDayIndex; i++) {
            $('#calendarDays').append('<div class="day empty"></div>'); // Celda vacía
        }

        // Iterar a través de los días del mes
        for (let i = 1; i <= lastDayOfMonth.getDate(); i++) {
            const dia = new Date(currentYear, currentMonth, i);
            const fecha = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

            const turno = turnos.find(t => t.fecha === fecha);
            const dayCell = $('<div class="day"></div>').text(i);

            if (turno) {
                if (turno.estado === "libre") {
                    dayCell.addClass('bg-success text-white'); // Día libre
                    dayCell.on('click', function() { // Evento click
                        mostrarHorarios(turnos, fecha);
                    });
                } else {
                    dayCell.addClass('bg-danger text-white'); // Día ocupado
                }
            } else {
                dayCell.addClass('bg-danger text-white'); // Día sin turnos
            }

            $('#calendarDays').append(dayCell);
        }
    }
    function mostrarHorarios(turnos, fecha) {
        $('#selectHorarios').empty(); // Limpiar select de horarios
        const horariosDisponibles = turnos
            .filter(t => t.fecha === fecha && t.estado === "libre") // Filtrar horarios libres;

        const valor = $('#id_paciente').val();
        //console.log(valor);
        //alert(valor);
        document.getElementById('hiddenId').value = valor;

        if (horariosDisponibles.length > 0) {
            horariosDisponibles.forEach(turno => {
                $('#selectHorarios').append(`<option value="${turno.id}">${turno.fecha} ${turno.hora}</option>`); // Agregar horarios al select
                
            });
            $('#horariosModal').modal('show'); // Mostrar modal
        } else {
            $('#selectHorarios').append('<option>No hay horarios disponibles</option>'); // Mensaje si no hay horarios
            $('#horariosModal').modal('show'); // Mostrar modal
        }
    }


    renderCalendar();

    $(document).ready(function() {
        $('#buscarPaciente').click(function() {
            const nroDocumento = $('#nro_documento').val();
            if (nroDocumento) {
                $.ajax({
                    url: `http://localhost/turnero/public/pacientes/buscar/${nroDocumento}`,
                    type: 'GET',
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        if (JSON.stringify(response) === '{}') {
                            //console.log('El objeto JSON está vacío');
                            data = [];
                        } else {
                            //console.log('El objeto JSON no está vacío');
                            data = response.paciente;
                        }
                        
                        //console.info(response);
                        //console.info(Object.keys(data).length);
                        if (Object.keys(data).length > 0){
                            console.info(data);
                            $('#nombre').val(data.nombre);
                            $('#apellido').val(data.apellido);
                            $('#email').val(data.email);
                            $('#telefono').val(data.telefono);
                            $('#obra_social').val(data.obra_social);
                            $('#id_paciente').val(data.id);
                            $('#mensaje').html(''); // Limpiar mensaje
                            $('#datosPaciente').show(); // Mostrar los campos
                            $('#cargarPaciente').hide(); // No Mostrar los campos
                            $('#datosPaciente input').attr('readonly', true); // Campos no editables
                            $('#mensaje').html('<div class="alert alert-success">Paciente encontrado.</div>');
                            generarCalendario(response.turnos);
                            $('#calendario').show();
                        } else { // Si hay un mensaje, significa que el paciente no fue encontrado
                            //console.info('vacio');
                            $('#mensaje').html('<div class="alert alert-warning">' + data.message + '</div>');
                            $('#datosPaciente').show(); // Mostrar los campos
                            $('#cargarPaciente').show(); // Mostrar los campos
                            $('#datosPaciente input').removeAttr('readonly'); // Hacerlos editables
                            $('#nombre').val('');
                            $('#apellido').val('');
                            $('#email').val('');
                            $('#telefono').val('');
                            $('#obra_social').val('');
                            $('#id_paciente').val('');
                            $('#calendario').hide();
                            $('#mensaje').html('<div class="alert alert-danger">No se encontro el paciente, cree un paciente nuevo: ingrese los datos.</div>');
                            
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                        $('#mensaje').html('<div class="alert alert-danger">Ocurrió un error en la búsqueda. Intenta nuevamente.</div>');
                    }
                });
            } else {
                $('#mensaje').html('<div class="alert alert-warning">Por favor ingresa un número de documento.</div>');
            }
        });

        // $('#nuevoPaciente').click(function() {
        //     // Redirigir a la página de carga de nuevo paciente
        //     window.location.href = '{{ route("pacientes.create") }}';
        // });
        $('#nuevoPaciente').click(function() {
            const formData = $('#pacienteForm').serializeArray(); // Serializar como array
            formData.push({ name: '_token', value: $('meta[name="csrf-token"]').attr('content') }); // Añadir CSRF manualmente

            $.ajax({
                url: '{{ route("turnos.guardarPacienteTurno") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    //console.info(response);
                    actualizarCalendario(response.turnos);
                    // $('#turnos').html('');
                    // $.each(response.turnos, function(index, turno) {
                    //     $('#turnos').append(`<div>Turno: ${turno.fecha} - ${turno.hora}</div>`);
                    // });
                },
                error: function(xhr, status, error) {
                    console.error('Error al guardar el paciente:', error);
                }
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#btnConfirmar').on('click', function() {
            // Obtener el ID del paciente y el horario seleccionado
            const pacienteId = $('#hiddenId').val();
            const horarioSeleccionadoId = $('#selectHorarios').val();
            const motivo = $('#motivo').val();
            $('#datosPaciente').hide();
            $('#calendario').hide();

            // Verificar que ambos datos estén presentes
            if (pacienteId && horarioSeleccionadoId) {
                // Enviar una solicitud AJAX al servidor para guardar el turno
                $.ajax({
                    url: 'http://localhost/turnero/public/turnos/guardar', // Cambia esta URL según tu ruta
                    type: 'POST',
                    data: {
                        paciente_id: pacienteId,
                        turno_id: horarioSeleccionadoId,
                        motivo: motivo
                    },
                    success: function(response) {
                        // Verificar si la respuesta fue exitosa
                        if (response && response.message) {
                            $('#horariosModal').modal('hide'); // Cerrar el modal
                            //alert(response.message); // Mostrar mensaje de éxito

                            // Si quieres actualizar la interfaz, puedes hacerlo aquí
                            // Por ejemplo, cambiar el color del día en el calendario a 'ocupado'
                            const turnoId = response.turno.id; // Suponiendo que se devuelve el turno actualizado
                            const fechaTurno = response.turno.fecha;
                            
                            // Marcar el día como ocupado en el calendario, ejemplo
                            $(`[data-fecha="${fechaTurno}"]`).removeClass('libre').addClass('ocupado');

                            // O actualizar un elemento en la página con detalles del turno
                            $('#detalleTurno').html(`Turno reservado para el ${fechaTurno} a las ${response.turno.hora}`);
                            $('#mensaje').html('<div class="alert alert-success">Turno reservado.</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al guardar el turno:', error);
                        // Mostrar el mensaje de error desde la respuesta del servidor si está disponible
                        const errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Ocurrió un error al guardar el turno. Intenta nuevamente.';
                        alert(errorMsg);
                    }
                });
            } else {
                alert('Por favor, selecciona un horario.');
            }
        });

    });
</script>
@endsection
