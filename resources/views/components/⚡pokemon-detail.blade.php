{{-- resources/views/livewire/pokemon-detail.blade.php --}}
<div class="max-w-2xl mx-auto p-6">
    <a href="{{ route('pokemon.index') }}" class="text-blue-600">&larr; Volver</a>

    <div class="text-center mt-4">
        <img src="{{ $pokemon['sprites']['front_default'] ?? '' }}" class="mx-auto w-40 h-40">
        <h1 class="text-2xl font-bold capitalize">{{ $pokemon['name'] }} #{{ $pokemon['id'] }}</h1>

        <div class="flex justify-center gap-2 my-3">
            @foreach ($pokemon['types'] as $type)
                <span class="px-3 py-1 bg-gray-200 rounded-full text-sm capitalize">
                    {{ $type['type']['name'] }}
                </span>
            @endforeach
        </div>

        <livewire:favorite-button
            :pokemon-id="$pokemon['id']"
            :pokemon-name="$pokemon['name']"
            :sprite="$pokemon['sprites']['front_default'] ?? null"
        />

        <div class="grid grid-cols-2 gap-3 mt-6 text-left">
            @foreach ($pokemon['stats'] as $stat)
                <div class="border rounded p-2">
                    <p class="text-xs text-gray-500 capitalize">{{ str_replace('-', ' ', $stat['stat']['name']) }}</p>
                    <p class="font-semibold">{{ $stat['base_stat'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>