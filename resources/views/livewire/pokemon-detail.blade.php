@php
    $mainType = $pokemon['types'][0]['type']['name'] ?? 'normal';
    $typeColor = "type-{$mainType}";
@endphp

<div class="max-w-3xl mx-auto px-4 py-8">

    <a href="{{ route('pokemon.index') }}"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-pokedex-red transition mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a la lista
    </a>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">

        <div class="{{ $typeColor }} relative px-6 pt-10 pb-20 text-center">
            <div class="absolute top-4 left-5 text-white/60 text-7xl font-black">
                #{{ str_pad($pokemon['id'], 3, '0', STR_PAD_LEFT) }}
            </div>
            <h1 class="relative text-3xl font-extrabold text-white capitalize drop-shadow-lg">
                {{ $pokemon['name'] }}
            </h1>
            <div class="absolute -bottom-16 left-1/2 -translate-x-1/2">
                <div class="bg-white rounded-full p-3 shadow-xl border-4 border-white">
                    <img src="{{ $pokemon['sprites']['front_default'] ?? '' }}"
                         alt="{{ $pokemon['name'] }}"
                         class="w-32 h-32">
                </div>
            </div>
        </div>

        <div class="pt-20 px-6 pb-8">

            <div class="flex justify-center gap-2 mb-6">
                @foreach ($pokemon['types'] as $type)
                    <span class="type-{{ $type['type']['name'] }} px-4 py-1.5 rounded-full text-white text-xs font-bold uppercase tracking-wider shadow-sm">
                        {{ $type['type']['name'] }}
                    </span>
                @endforeach
            </div>

            <div class="flex justify-center gap-8 mb-8 text-center">
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $pokemon['height'] / 10 }}m</p>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Altura</p>
                </div>
                <div class="w-px bg-gray-200"></div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $pokemon['weight'] / 10 }}kg</p>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Peso</p>
                </div>
            </div>

            <div class="flex justify-center mb-8">
                <livewire:favorite-button
                    :pokemon-id="$pokemon['id']"
                    :pokemon-name="$pokemon['name']"
                    :sprite="$pokemon['sprites']['front_default'] ?? null"
                />
            </div>

            <h2 class="text-lg font-bold text-gray-800 mb-4">Estadísticas base</h2>
            <div class="space-y-3">
                @foreach ($pokemon['stats'] as $stat)
                    @php
                        $statName = $stat['stat']['name'];
                        $statValue = $stat['base_stat'];
                        $percent = min(100, ($statValue / 255) * 100);
                        $statClass = "stat-" . $statName;
                    @endphp
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-semibold text-gray-500 uppercase w-28 text-right shrink-0">
                            {{ str_replace('-', ' ', $statName) }}
                        </span>
                        <span class="text-sm font-bold text-gray-700 w-8 text-right">{{ $statValue }}</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="{{ $statClass }} h-full rounded-full transition-all duration-700 ease-out"
                                 style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if (!empty($pokemon['abilities']))
                <h2 class="text-lg font-bold text-gray-800 mt-8 mb-3">Habilidades</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach ($pokemon['abilities'] as $ability)
                        <span class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg text-xs font-semibold capitalize">
                            {{ str_replace('-', ' ', $ability['ability']['name']) }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>