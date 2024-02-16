<?php

namespace App\Services;

use App\Repositories\LikeRepository;
use App\Repositories\ShopRepository;
use App\Repositories\ReservationRepository;
use Illuminate\Support\Facades\Storage;

class UserService
{
    private $likeRepository;
    private $shopRepository;
    private $reservationRepository;

    public function __construct(
        LikeRepository $likeRepository,
        ShopRepository $shopRepository,
        ReservationRepository $reservationRepository,
    ) {
        $this->likeRepository = $likeRepository;
        $this->shopRepository = $shopRepository;
        $this->reservationRepository = $reservationRepository;
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
}
