<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Compacto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="calendar">
            <div class="calendar-header" id="calendarMonth"></div>
            <div class="days-of-week">
                <div class="day">Dom</div>
                <div class="day">Lun</div>
                <div class="day">Mar</div>
                <div class="day">Mié</div>
                <div class="day">Jue</div>
                <div class="day">Vie</div>
                <div class="day">Sáb</div>
            </div>
            <div class="calendar-days" id="calendarDays"></div>
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
                const className = occupied ? 'occupied' : 'available';
                daysHTML += `<div class="day ${className}">${i}</div>`;
            }
            document.getElementById('calendarDays').innerHTML = daysHTML;
        }

        renderCalendar();
    </script>
</body>
</html>
