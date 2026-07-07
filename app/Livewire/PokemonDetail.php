<?php
namespace App\Livewire;

use App\Services\PokeApiService;
use Livewire\Component;

class PokemonDetail extends Component
{
    public array $pokemon = [];

    public function mount(string $identifier, PokeApiService $pokeApi): void
    {
        $this->pokemon = $pokeApi->find($identifier) ?? abort(404);
    }

    public function render()
    {
        return view('livewire.pokemon-detail');
    }
}