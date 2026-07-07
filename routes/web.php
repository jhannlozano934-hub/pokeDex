<?php
use App\Livewire\PokemonList;
use App\Livewire\PokemonDetail;

Route::get('/', PokemonList::class)->name('pokemon.index');
Route::get('/pokemon/{identifier}', PokemonDetail::class)->name('pokemon.show');