<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Pokédex' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pokedex.css') }}">

    <!-- Esta es la configuración de Tailwind -->

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif']},
                    colors: {
                        pokedex: { red: '#DC143C', darkred: '#A30720', yellow: '#FFCC00'}
                    }
                }
            }
        }
    </script>

</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">
    <header class="bg-gradient-to-r from-pokedex-red to-pokedex-darkred shadow-lg">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center gap-3">
            <svg class="w-10 h-10" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="48" fill="#fff" stroke="#333" stroke-width="4"/>
                <line x1="2" y1="50" x2="98" y2="50" stroke="#333" stroke-width="4"/>
                <circle cx="50" cy="50" r="18" fill="#fff" stroke="#333" stroke-width="4"/>
                <circle cx="50" cy="50" r="10" fill="#fff" stroke="#333" stroke-width="3"/>
                <circle cx="50" cy="50" r="5" fill="#DC0A2D"/>
            </svg>
            <a href="{{ route('pokemon.index') }}" class="text-2xl font-extrabold text-white tracking-tight">Pokédex</a>
        </div>
    </header>

    <main class="pokeball-bg min-h-[calc(100vh-140px)]">
        {{ $slot }}
    </main>

    <footer class="bg-gray-800 text-gray-400 text-center py-4 text-sm">
        Pokédex &copy; {{ date('Y') }} — Powered by <a href="https://pokeapi.co" target="_blank" class="underline hover:text-white">PokeAPI</a>
    </footer>
</body>
</html>