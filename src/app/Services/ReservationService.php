<?php

namespace App\Services;

use App\Repositories\ShopRepository;
use App\Repositories\ReservationRepository;
use Illuminate\Support\Facades\Storage;

class ReservationService
{
    private $shopRepository;
    private $reservationRepository;

    public function __construct(
        ShopRepository $shopRepository,
        ReservationRepository $reservationRepository,
    ) {
        $this->shopRepository = $shopRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function reserve(int $userId, string $shopId, string $date, string $time, string $numPeople): void
    {
        $this->reservationRepository->register($userId, $shopId, $date . ' ' . $time, $numPeople);
    }


    public function deleteReservation(int $userId, string $reservationId): bool
    {
        if ($this->reservationRepository->count($userId, $reservationId) != 1) {
            return false;
        }
        $this->reservationRepository->delete($reservationId);
        return True;
    }

    public function getModifyReservationInfo(int $userId, string $reservationId): array
    {
        if ($this->reservationRepository->count($userId, $reservationId) != 1) {
            return [null, null, null];
        }
        $reservation = $this->reservationRepository->find($reservationId);

        $shop = $this->shopRepository->find($reservation->shop_id, $userId);
        if (is_null($shop)) {
            return [null, null, null];
        }

        $image = Storage::disk('s3')->url($shop->image, now()->addMinute());
        return [$reservation, $shop, $image];
    }

    public function modifyReservation(int $userId, string $reservationId, string $date, string $time, string $numPeople): bool
    {

        if ($this->reservationRepository->count($userId, $reservationId) != 1) {
            return false;
        }
        if ($this->reservationRepository->modify($reservationId, $date . ' ' . $time, $numPeople) != 1) {
            return false;
        }
        return true;
    }

    public function getReservationList(string $shopId): array
    {
        $shop = $this->shopRepository->find($shopId, null);

        if (is_null($shop)) {
            return [null, null];
        }

        [$reservationsToday, $reservationsAfterToday] = $this->reservationRepository->getReservationListOfShop($shopId);

        return [$shop, $reservationsToday, $reservationsAfterToday];
    }
}
