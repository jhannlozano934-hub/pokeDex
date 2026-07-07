{{-- resources/views/livewire/favorite-button.blade.php --}}
<button
    wire:click="toggle"
    class="mt-2 px-4 py-2 rounded-full text-sm {{ $isFavorite ? 'bg-yellow-400' : 'bg-gray-200' }}"
>
    {{ $isFavorite ? '★ En favoritos' : '☆ Agregar a favoritos' }}
</button>