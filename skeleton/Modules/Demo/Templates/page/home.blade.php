<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $me->title }}</title>
</head>
<body>
    <h1>¡Hola desde Alxarafe!</h1>
    <p>Esta es una aplicación de demostración corriendo sobre el framework local.</p>
    
    <hr>
    
    <h3>Configuración Actual:</h3>
    <pre>{{ print_r($me->config, true) }}</pre>
</body>
</html>
