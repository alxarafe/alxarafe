<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $me->title }}</title>
</head>
<body>
    <h1>{{ $me->title }}</h1>
    <p>Mantenimiento de personas para la agenda personal.</p>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha de Nacimiento</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- Aquí se iteraría sobre las personas si hubiera datos --}}
            <tr>
                <td colspan="4">No hay datos disponibles (Prueba de entorno).</td>
            </tr>
        </tbody>
    </table>

    <p>
        <a href="index.php?module=Agenda&controller=Person&action=create">Añadir Persona</a>
    </p>

    <hr>
    <p><a href="index.php">Volver al Inicio</a></p>
</body>
</html>
