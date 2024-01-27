<?php

namespace App\Services;

use App\Repositories\AreaRepository;
use App\Repositories\GenreRepository;
use App\Repositories\LikeRepository;
use App\Repositories\ShopRepository;
use App\Repositories\ReserveRepository;
use Illuminate\Support\Facades\Storage;

class ShopService
{
    private $areaRepository;
    private $genreRepository;
    private $likeRepository;
    private $shopRepository;
    private $reserveRepository;

    public function __construct(
        AreaRepository $areaRepository,
        GenreRepository $genreRepository,
        LikeRepository $likeRepository,
        ShopRepository $shopRepository,
        ReserveRepository $reserveRepository,
    ) {
        $this->areaRepository = $areaRepository;
        $this->genreRepository = $genreRepository;
        $this->likeRepository = $likeRepository;
        $this->shopRepository = $shopRepository;
        $this->reserveRepository = $reserveRepository;
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
        $this->reserveRepository->register($userId, $shopId, $date . ' ' . $time, $numPeople);
    }
}
