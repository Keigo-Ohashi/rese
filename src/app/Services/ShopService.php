<?php

namespace App\Services;

use App\Repositories\AreaRepository;
use App\Repositories\GenreRepository;
use App\Repositories\ShopRepository;
use Illuminate\Support\Facades\Storage;

class ShopService
{
    private $shopRepository;
    private $areaRepository;
    private $genreRepository;

    public function __construct(
        AreaRepository $areaRepository,
        GenreRepository $genreRepository,
        ShopRepository $shopRepository
    ) {
        $this->areaRepository = $areaRepository;
        $this->genreRepository = $genreRepository;
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
}
