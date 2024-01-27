<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Shop;
use App\Models\Reserve;

class ReserveRepository
{
    public function register(int $userId, string $shopId, string $dateTime, string $numPeople): void
    {
        Reserve::create([
            'user_id' => $userId,
            'shop_id' => $shopId,
            'date_time' => $dateTime,
            'num_people' => $numPeople,
        ]);
    }
}
