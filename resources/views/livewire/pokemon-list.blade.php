<div class="max-w-6xl mx-auto px-4 py-8">

    <div class="text-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">Encuentra tu Pokémon</h1>
        <p class="text-gray-500 mt-2">Explora el mundo de los Pokémon</p>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 mb-8 max-w-2xl mx-auto">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input
                type="text"
                wire:model.live.debounce.400ms="search"
                placeholder="Buscar pokémon..."
                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-pokedex-red focus:border-transparent transition"
            >
        </div>
        <select
            wire:model.live="selectedType"
            class="px-4 py-3 rounded-xl border border-gray-200 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-pokedex-red focus:border-transparent transition appearance-none cursor-pointer"
        >
            <option value="">Todos los tipos</option>
            @foreach ($this->types as $type)
                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>

    <div wire:loading.class="opacity-100" wire:loading class="hidden opacity-0 transition-opacity duration-300 mb-6">
        <div class="flex items-center justify-center gap-2 text-gray-500">
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <span class="text-sm font-medium">Cargando pokémon...</span>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        @forelse ($this->pokemons as $pokemon)
            <a href="{{ route('pokemon.show', $pokemon['name']) }}"
               class="card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-center group">
                <div class="bg-gradient-to-b from-gray-50 to-white p-4 pt-6 relative">
                    @if ($pokemon['sprite'])
                        <img src="{{ $pokemon['sprite'] }}"
                             alt="{{ $pokemon['name'] }}"
                             class="mx-auto w-24 h-24 drop-shadow-md group-hover:scale-110 transition-transform duration-300">
                    @endif
                </div>
                <div class="px-3 pb-4">
                    <p class="text-xs text-gray-400 font-medium">#{{ str_pad($pokemon['id'], 3, '0', STR_PAD_LEFT) }}</p>
                    <p class="capitalize font-bold text-gray-800 mt-0.5">{{ $pokemon['name'] }}</p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-16">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-400 font-medium">Sin resultados para "{{ $search }}"</p>
            </div>
        @endforelse
    </div>

    @if ($this->pokemons->hasPages())
        <div class="mt-10 flex justify-center items-center gap-1.5">
            @if ($this->pokemons->currentPage() > 1)
                <button wire:click="goToPage({{ $this->pokemons->currentPage() - 1 }})"
                        class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition">
                    &laquo;
                </button>
            @endif

            @php
                $currentPage = $this->pokemons->currentPage();
                $lastPage = $this->pokemons->lastPage();
                $range = 2;
                $start = max(1, $currentPage - $range);
                $end = min($lastPage, $currentPage + $range);
            @endphp

            @if ($start > 1)
                <button wire:click="goToPage(1)" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition">1</button>
                @if ($start > 2)
                    <span class="px-1 text-gray-400">...</span>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                <button wire:click="goToPage({{ $i }})"
                        class="w-10 h-10 rounded-lg text-sm font-bold transition {{ $i === $currentPage ? 'bg-pokedex-red text-white shadow-md shadow-red-200' : 'text-gray-600 bg-white border border-gray-200 hover:bg-gray-50' }}">
                    {{ $i }}
                </button>
            @endfor

            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <input
                        type ="text"
                        wire:keydown.enter="goToInputPage($event.target.value)"
                        placeholder="..."
                        class="w-12 px-2 py-1.5 text-center text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pokedex-red focus:border-transparent transition"
                    >
                @endif
                <button wire:click="goToPage({{ $lastPage }})" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition">{{ $lastPage }}</button>
            @endif

            @if ($this->pokemons->currentPage() < $lastPage)
                <button wire:click="goToPage({{ $this->pokemons->currentPage() + 1 }})"
                        class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition">
                    &raquo;
                </button>
            @endif
        </div>
    @endif
</div>