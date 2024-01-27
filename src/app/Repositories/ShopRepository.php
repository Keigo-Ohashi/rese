<?php

namespace App\Repositories;

use App\Models\Like;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Shop;

class ShopRepository
{
    public function getAll(?string $areaId, ?string $genreId, ?string $shopName, ?int $userId): Collection
    {
        if (is_null($shopName)) {
            $shops = Shop::where('shops.name', 'like', '%');
        } else {
            $shops = Shop::where('shops.name', 'like', '%' . $shopName . '%');
        }
        if (!is_null($areaId)) {
            $shops = $shops->where('area_id',  $areaId);
        }
        if (!is_null($genreId)) {
            $shops = $shops->where('genre_id',  $genreId);
        }


        return $shops->join('areas', 'shops.area_id',  'areas.id')
            ->join('genres', 'shops.genre_id',  'genres.id')
            ->leftJoin('likes', function ($join) use ($userId) {
                $join->on('shops.id',  'likes.shop_id')->where('likes.user_id',  $userId);
            })
            ->select('shops.*', 'areas.name as area_name', 'genres.name as genre_name', 'likes.id as like_id')
            ->orderBy('shops.id')
            ->get();
    }

    public function find(string $shopId, ?int $userId): ?Shop
    {
        return Shop::join('areas', 'shops.area_id',  'areas.id')
            ->join('genres', 'shops.genre_id',  'genres.id')
            ->leftJoin('likes', function ($join) use ($userId) {
                $join->on('shops.id',  'likes.shop_id')->where('likes.user_id',  $userId);
            })
            ->where('shops.id', $shopId)
            ->select('shops.*', 'areas.name as area_name', 'genres.name as genre_name', 'likes.id as like_id')
            ->first();
    }
}
