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

    public function searchOption(): Collection
    {
        return Area::join('shops', 'areas.id', '=', 'shops.area_id')->groupBy('areas.id')->select('areas.*')->get();
    }
}
