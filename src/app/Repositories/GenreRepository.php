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
}
