<div class="max-w-5xl mx-auto p-6">
    <div class="flex gap-4 mb-6">
        <input
            type="text"
            wire:model.live.debounce.400ms="search"
            placeholder="Buscar pokémon..."
            class="border rounded-lg px-4 py-2 w-full"
        >
        <select wire:model.live="selectedType" class="border rounded-lg px-4 py-2">
            <option value="">Todos los tipos</option>
            @foreach ($this->types as $type)
            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>

    <div wire:loading class="text-sm text-gray-500 mb-4">Cargando...</div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse ($this->pokemons as $pokemon)
            <a href="{{ route('pokemon.show', $pokemon['name']) }}"
               class="border rounded-xl p-4 text-center hover:shadow-lg transition">
                @if ($pokemon['sprite'])
                    <img src="{{ $pokemon['sprite'] }}" class="mx-auto w-20 h-20">
                @endif
                <p class="capitalize font-semibold mt-2">{{ $pokemon['name'] }}</p>
                <p class="text-xs text-gray-400">#{{ $pokemon['id'] }}</p>
            </a>
        @empty
            <p class="col-span-full text-center text-gray-500">Sin resultados.</p>
        @endforelse
    </div>

    <div class="mt-6 flex justify-center gap-2">
        @for ($i = 1; $i <= $this->pokemons->lastPage(); $i++)
            <button
                wire:click="goToPage({{ $i }})"
                class="px-3 py-1 rounded {{ $i === $this->pokemons->currentPage() ? 'bg-blue-600 text-white' : 'bg-gray-100' }}"
            >{{ $i }}</button>
        @endfor
    </div>
</div>