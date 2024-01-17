<?php

namespace App\Repositories;

use App\Models\Like;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Shop;

class ShopRepository
{
    public function getAll(?int $userId): Collection
    {
        // if (is_null($userId)) {
        //     return Shop::join('areas', 'shops.area_id', '=', 'areas.id')
        //         ->join('genres', 'shops.genre_id', "=", "genres.id")
        //         ->select('shops.*', 'areas.name as area_name', 'genres.name as genre_name')
        //         ->orderBy('shops.id')
        //         ->get();
        // }

        $likes = Like::where('user_id', '=', $userId);
        return Shop::join('areas', 'shops.area_id', '=', 'areas.id')
            ->join('genres', 'shops.genre_id', "=", "genres.id")
            ->leftJoin('likes', function ($join) use ($userId) {
                $join->on('shops.id', '=', 'likes.shop_id')->where('likes.user_id', '=', $userId);
            })
            ->select('shops.*', 'areas.name as area_name', 'genres.name as genre_name', 'likes.id as like_id')
            ->orderBy('shops.id')
            ->get();
    }
}
