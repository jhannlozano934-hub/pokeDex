<?php
namespace App\Livewire;

use App\Services\PokeApiService;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PokemonList extends Component
{
    public string $search = '';
    public string $selectedType = '';
    public int $page = 1;
    protected int $perPage = 20;

    public function updatedSearch(): void { $this->page = 1; }
    public function updatedSelectedType(): void { $this->page = 1; }

    public function goToPage(int $page): void
    {
        $this->page = $page;
    }

    #[Computed]
    public function types(): array
    {
        return app(PokeApiService::class)->types();
    }

    #[Computed]
    public function pokemons(): LengthAwarePaginator
    {
        $pokeApi = app(PokeApiService::class);
        $all = collect($pokeApi->allNames());

        if ($this->selectedType) {
            $namesInType = $pokeApi->byType($this->selectedType);
            $all = $all->filter(fn ($p) => in_array($p['name'], $namesInType));
        }

        if ($this->search !== '') {
            $term = strtolower($this->search);
            $all = $all->filter(fn ($p) => str_contains($p['name'], $term));
        }

        $all = $all->values();
        $total = $all->count();

        $items = $all->slice(($this->page - 1) * $this->perPage, $this->perPage)
            ->map(function ($item) use ($pokeApi) {
                $details = $pokeApi->find($item['name']);
                return [
                    'id' => $details['id'] ?? null,
                    'name' => $details['name'] ?? $item['name'],
                    'sprite' => $details['sprites']['front_default'] ?? null,
                ];
            });

        return new LengthAwarePaginator($items, $total, $this->perPage, $this->page);
    }

    public function render()
    {
        return view('livewire.pokemon-list');
    }
}