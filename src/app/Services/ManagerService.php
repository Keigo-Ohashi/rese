<?php

namespace App\Services;

use App\Repositories\AreaRepository;
use App\Repositories\GenreRepository;
use App\Repositories\LikeRepository;
use App\Repositories\ShopRepository;
use App\Repositories\ReservationRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ManagerService
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

    public function getShopInfoRegisterForm()
    {
        return $this->getShopInfoOptions();
    }

    public function getShopInfoModifyForm()
    {
        [$areas, $genres] = $this->getShopInfoOptions();
    }

    private function getShopInfoOptions(): array
    {
        $areas = $this->areaRepository->getAll();
        $genres = $this->genreRepository->getAll();
        return [$areas, $genres];
    }

    public function registerShopInfo(string $name, string $areaId, string $genreId, string $detail, UploadedFile $image): bool
    {
        if (is_null($this->areaRepository->find($areaId))) {
            return false;
        }

        if (is_null($this->genreRepository->find($genreId))) {
            return false;
        }

        $imageName = Storage::disk('s3')->put('image', $image, 'public');

        $this->shopRepository->register($name, $areaId, $genreId, $detail, $imageName);

        return true;
    }
}
