<?php

namespace App\Services;

use App\Repositories\AreaRepository;
use App\Repositories\GenreRepository;
use App\Repositories\LikeRepository;
use App\Repositories\ShopRepository;
use App\Repositories\ReservationRepository;
use Illuminate\Support\Facades\Storage;

class ShopService
{
    private $areaRepository;
    private $genreRepository;
    private $likeRepository;
    private $shopRepository;
    private $reservationRepository;

    public function __construct(
        AreaRepository $areaRepository,
        GenreRepository $genreRepository,
        LikeRepository $likeRepository,
        ShopRepository $shopRepository,
        ReservationRepository $reservationRepository,
    ) {
        $this->areaRepository = $areaRepository;
        $this->genreRepository = $genreRepository;
        $this->likeRepository = $likeRepository;
        $this->shopRepository = $shopRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function getShopListInfo(?string $areaId, ?string $genreId, ?string $shopName, ?int $userId): array
    {
        $shops = $this->shopRepository->getAll($areaId, $genreId, $shopName, $userId);
        $areas = $this->areaRepository->searchOption();
        $genres = $this->genreRepository->searchOption();

        $images = [];
        foreach ($shops as $shop) {
            $images[$shop->id] = Storage::disk('s3')->url($shop->image, now()->addMinute());
        }

        return [$shops, $areas, $genres, $images];
    }

    public function getShopInfo(string $shopId, ?int $userId): array
    {
        $shop = $this->shopRepository->find($shopId, $userId);
        if (is_null($shop)) {
            return [null, null];
        }

        $image = Storage::disk('s3')->url($shop->image, now()->addMinute());
        return [$shop, $image];
    }

    public function likeShop(int $userId, int $shopId): bool
    {
        if ($this->likeRepository->count($userId, $shopId) == 0) {
            $this->likeRepository->create($userId, $shopId);
            return true;
        }
        return false;
    }

    public function unlikeShop(int $userId, int $shopId): bool
    {
        if ($this->likeRepository->count($userId, $shopId) == 1) {
            $this->likeRepository->delete($userId, $shopId);
            return true;
        }
        return false;
    }

    public function reserve(int $userId, string $shopId, string $date, string $time, string $numPeople): void
    {
        $this->reservationRepository->register($userId, $shopId, $date . ' ' . $time, $numPeople);
    }

    public function getMyPageInfo(int $userId): array
    {
        $shops = $this->shopRepository->getLikeShop($userId);
        $images = [];
        foreach ($shops as $shop) {
            $images[$shop->id] = Storage::disk('s3')->url($shop->image, now()->addMinute());
        }
        $reservations = $this->reservationRepository->getReservationList($userId);

        return [$shops, $images, $reservations];
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
        $reservation = $this->reservationRepository->find($reservationId);
        if (is_null($reservation)) {
            return [null, null, null];
        }

        $shop = $this->shopRepository->find($reservation->shop_id, $userId);
        if (is_null($shop)) {
            return [null, null, null];
        }

        $image = Storage::disk('s3')->url($shop->image, now()->addMinute());
        return [$reservation, $shop, $image];
    }
}
