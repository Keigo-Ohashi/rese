<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

use App\Models\Shop;
use App\Models\Reservation;

class ReservationRepository
{
    public function register(int $userId, string $shopId, string $dateTime, string $numPeople): void
    {
        Reservation::create([
            'user_id' => $userId,
            'shop_id' => $shopId,
            'date_time' => $dateTime,
            'num_people' => $numPeople,
        ]);
    }

    public function getReservationList(int $userId): Collection
    {
        return Reservation::where('user_id', $userId)->where('date_time', '>', Carbon::now())
            ->join('shops', 'reservations.shop_id', 'shops.id')
            ->select('reservations.*', 'shops.name as shop_name')
            ->get();
    }
}
