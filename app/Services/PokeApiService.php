<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PokeApiService {
    private string $baseUrl = 'https://pokeapi.co/api/v2/';

    /**
     * Obtener todos los nombres y ids de los pokemones (cacheado por 24 horas)
     */
    public function getAllPokemonsNames(): array {
        return Cache::remember('all-pokemons-names', 24 * 60, function () {
            $response = Http::get("{$this->baseUrl}pokemon?limit=10000");
            $results = $response->json('results', []);

            return collect($results)->map(function ($pokemon) {
                return [
                    'name' => $pokemon['name'],
                    'id'   => $this->extractIdFromUrl($pokemon['url']),
                ];
            })->toArray();
        });
    }

    /**
     * Buscar un pokemon por nombre
     * Devuelve full api response
     */
    public function find(string $name): ?array {
        $cacheKey = 'pokeapi_pokemon_' . strtolower($name);

        return Cache::remember($cacheKey, 24 * 60, function () use ($name) {
            $response = Http::get("{$this->baseUrl}pokemon/" . urlencode(strtolower($name)));

            if ($response->failed()) {
                return null;
            }

            return $response->json();
        });
    }

    /**
     * Obtener pokemon formateado para mostrar
     */
    public function findFormatted(string $name): ?array {
        $data = $this->find($name);

        if (!$data) {
            return null;
        }

        return [
            'id'          => $data['id'],
            'name'        => ucfirst($data['name']),
            'sprite'      => $data['sprites']['other']['official-artwork']['front_default']
                             ?? $data['sprites']['front_default']
                             ?? null,
            'types'       => collect($data['types'])
                                ->sortBy('slot')
                                ->pluck('type.name')
                                ->toArray(),
            'height'      => $data['height'] / 10,
            'weight'      => $data['weight'] / 10,
            'stats'       => collect($data['stats'])->mapWithKeys(fn($s) => [
                                $s['stat']['name'] => $s['base_stat']
                            ])->toArray(),
            'abilities'   => collect($data['abilities'])
                                ->pluck('ability.name')
                                ->toArray(),
            'description' => $this->getDescription($data['species']['url'] ?? null),
        ];
    }

    /**
     * Obtener todos los tipos de pokemones
     */
    public function types(): array {
        return Cache::remember('pokeapi_types', 24 * 60, function () {
            $response = Http::get("{$this->baseUrl}type");
            $response->throw();

            return collect($response->json('results', []))
                ->pluck('name')
                ->values()
                ->toArray();
        });
    }

    /**
     * Obtener los nombres de pokemon por el tipo dado
     */
    public function byType(string $type): array {
        $cacheKey = "pokeapi_type_{$type}";

        return Cache::remember($cacheKey, 24 * 60, function () use ($type) {
            $response = Http::get("{$this->baseUrl}type/" . urlencode($type));

            if ($response->failed()) {
                return [];
            }

            return collect($response->json('pokemon', []))
                ->pluck('pokemon.name')
                ->toArray();
        });
    }

    /**
     * Obtener la descripcion de las especies
     */
    private function getDescription(?string $speciesUrl): ?string {
        if (!$speciesUrl) {
            return null;
        }

        $cacheKey = 'pokeapi_species_' . md5($speciesUrl);

        return Cache::remember($cacheKey, 24 * 60, function () use ($speciesUrl) {
            $response = Http::get($speciesUrl);

            if ($response->failed()) {
                return null;
            }

            $flavorTexts = $response->json('flavor_text_entries', []);

            //preferir español, luego inglés, se usa .last() para obtener la más reciente
            $text = collect($flavorTexts)
                ->where('language.name', 'es')
                ->last()['flavor_text']
                ?? collect($flavorTexts)
                    ->where('language.name', 'en')
                    ->last()['flavor_text']
                    ?? null;

            if ($text) {
                $text = str_replace(["\n", "\r", "\f"], ' ', $text);
                $text = trim($text);
            }

            return $text;
        });
    }

    /**
     * Extraer pokemon id de PokeAPI URL
     * "https://pokeapi.co/api/v2/pokemon/25/" => 25
     */
    private function extractIdFromUrl(string $url): int {
        preg_match('/\/(\d+)\/$/', $url, $matches);
        return (int) ($matches[1] ?? 0);
    }
}