<?php

namespace App\Services;

use App\Repositories\AreaRepository;
use App\Repositories\GenreRepository;
use App\Repositories\LikeRepository;
use App\Repositories\ShopRepository;
use Illuminate\Support\Facades\Storage;

class ShopService
{
    private $shopRepository;
    private $areaRepository;
    private $likeRepository;
    private $genreRepository;

    public function __construct(
        AreaRepository $areaRepository,
        GenreRepository $genreRepository,
        LikeRepository $likeRepository,
        ShopRepository $shopRepository
    ) {
        $this->areaRepository = $areaRepository;
        $this->genreRepository = $genreRepository;
        $this->likeRepository = $likeRepository;
        $this->shopRepository = $shopRepository;
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
}
