<?php

namespace App\Services;

use App\Repositories\AreaRepository;
use App\Repositories\GenreRepository;
use App\Repositories\ShopRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ShopService
{
    private $areaRepository;
    private $genreRepository;
    private $shopRepository;

    public function __construct(
        AreaRepository $areaRepository,
        GenreRepository $genreRepository,
        ShopRepository $shopRepository,
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

    public function getShopInfo(string $shopId, ?int $userId): array
    {
        $shop = $this->shopRepository->find($shopId, $userId);
        if (is_null($shop)) {
            return [null, null];
        }

        $image = Storage::disk('s3')->url($shop->image, now()->addMinute());
        return [$shop, $image];
    }



    public function getShopInfoRegisterForm()
    {
        return $this->getShopInfoOptions();
    }

    private function getShopInfoOptions(): array
    {
        $areas = $this->areaRepository->getAll();
        $genres = $this->genreRepository->getAll();
        return [$areas, $genres];
    }

    public function registerShopInfo(string $name, string $areaId, string $genreId, string $detail, string $imagePath): bool
    {
        if (is_null($this->areaRepository->find($areaId))) {
            return false;
        }

        if (is_null($this->genreRepository->find($genreId))) {
            return false;
        }

        $image = new UploadedFile(storage_path("app/public/" . $imagePath), basename($imagePath));
        $imageName = Storage::disk("s3")->put("image", $image, "public");

        $this->shopRepository->register($name, $areaId, $genreId, $detail, $imageName);

        return true;
    }

    public function getShopInfoModifyForm(string $shopId): array
    {
        $shop = $this->shopRepository->find($shopId, null);
        if (is_null($shop)) {
            return [null, null, null, null];
        }

        $image = Storage::disk('s3')->url($shop->image, now()->addMinute());
        [$areas, $genres] = $this->getShopInfoOptions();

        return [$shop, $image, $areas, $genres];
    }

    public function modifyShopInfo(string $id, string $name, string $areaId, string $genreId, string $detail, string $imagePath): bool
    {
        $shop = $this->shopRepository->find($id, null);
        if (is_null($shop)) {
            return false;
        }

        if (is_null($this->areaRepository->find($areaId))) {
            return false;
        }

        if (is_null($this->genreRepository->find($genreId))) {
            return false;
        }

        if ($imagePath != $shop->image) {
            Storage::disk("s3")->delete($shop->image);
            $image = new UploadedFile(storage_path("app/public/" . $imagePath), basename($imagePath));
            $imagePath = Storage::disk("s3")->put("image", $image, "public");
        }

        $this->shopRepository->modify($id, $name, $areaId, $genreId, $detail, $imagePath);

        return true;
    }
}
