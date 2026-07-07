<?php
namespace App\Livewire;

use App\Models\Favorite;
use Livewire\Component;

class FavoriteButton extends Component
{
    public int $pokemonId;
    public string $pokemonName;
    public ?string $sprite = null;
    public bool $isFavorite = false;

    public function mount(int $pokemonId, string $pokemonName, ?string $sprite = null): void
    {
        $this->pokemonId = $pokemonId;
        $this->pokemonName = $pokemonName;
        $this->sprite = $sprite;
        $this->isFavorite = Favorite::forCurrentVisitor()
            ->where('pokemon_id', $this->pokemonId)->exists();
    }

    public function toggle(): void
    {
        $existing = Favorite::forCurrentVisitor()
            ->where('pokemon_id', $this->pokemonId)->first();

        if ($existing) {
            $existing->delete();
            $this->isFavorite = false;
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'session_id' => auth()->check() ? null : session()->getId(),
                'pokemon_id' => $this->pokemonId,
                'pokemon_name' => $this->pokemonName,
                'sprite_url' => $this->sprite,
            ]);
            $this->isFavorite = true;
        }
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}