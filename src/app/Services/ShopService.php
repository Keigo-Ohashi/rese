<?php

namespace App\Services;

use App\Repositories\AreaRepository;
use App\Repositories\GenreRepository;
use App\Repositories\ShopRepository;

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

    public function getShopListInfo(): array
    {
        $shops = $this->shopRepository->getAll();
        $areas = $this->areaRepository->getAll();
        $genres = $this->genreRepository->getAll();

        return [$shops, $areas, $genres];
    }
}
