<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Shop;

class ShopRepository
{
    public function getAll(): Collection
    {
        return Shop::all();
    }
}
