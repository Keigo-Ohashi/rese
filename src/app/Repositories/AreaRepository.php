<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Area;

class AreaRepository
{
    public function getAll(): Collection
    {
        return Area::all();
    }
}
