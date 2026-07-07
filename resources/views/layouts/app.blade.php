<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Pokédex' }}</title>
</head>
<body class="bg-gray-100 min-h-screen">
    {{ $slot }}
</body>
</html>