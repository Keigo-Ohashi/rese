<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Genre;

class GenreRepository
{
    public function getAll(): Collection
    {
        return Genre::all();
    }

    public function searchOption(): Collection
    {
        return Genre::join('shops', 'genres.id', 'shops.genre_id')->groupBy('genres.id')->select('genres.*')->get();
    }
}
