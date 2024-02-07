<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

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
            ->orderBy('reservations.date_time')
            ->get();
    }

    public function count(int $userId, string $reservationId): int
    {
        return Reservation::where('user_id', $userId)->where('id', $reservationId)->count();
    }

    public function delete(string $reservationId): int
    {
        return Reservation::where('id', $reservationId)->delete();
    }

    public function find(string $reservationId): Reservation
    {
        return Reservation::find($reservationId);
    }

    public function modify(string $reservationId, string $dateTime, string $numPeople): int
    {
        return Reservation::find($reservationId)->update(['date_time' => $dateTime, 'num_people' => $numPeople]);
    }

    public function getReservationListOfShop(string $shopId): array
    {
        $reservationsToday =
            Reservation::where("shop_id", $shopId)
            ->whereDate("date_time",  Carbon::today())
            ->join('users', 'reservations.user_id', 'users.id')
            ->select('reservations.*', 'users.name as user_name')
            ->orderBy('reservations.date_time')
            ->get();

        $reservationsAfterToday =
            Reservation::where("shop_id", $shopId)
            ->where("date_time", ">=", Carbon::tomorrow())
            ->join('users', 'reservations.user_id', 'users.id')
            ->select('reservations.*', 'users.name as user_name')
            ->orderBy('reservations.date_time')
            ->get();

        return [$reservationsToday, $reservationsAfterToday];
    }
}
