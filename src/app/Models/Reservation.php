<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'date_time',
        'num_people',
        'is_came',
    ];

    protected $dates = ['date_time'];

    public function getDateAttribute()
    {
        return $this->date_time->format('Y-m-d');
    }

    public function getTimeAttribute()
    {
        return $this->date_time->format('H:i');
    }
}
