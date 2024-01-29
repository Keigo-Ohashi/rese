<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Like;

class LikeRepository
{
    public function create(int $userId, int $shopId): void
    {
        Like::create([
            'user_id' => $userId,
            'shop_id' => $shopId,
        ]);
    }

    public function delete(int $userId, int $shopId): void
    {
        Like::where('user_id', $userId)->where('shop_id', $shopId)->delete();
    }

    public function count(int $userId, int $shopId): int
    {
        return Like::where('user_id', $userId)->where('shop_id', $shopId)->count();
    }
}
