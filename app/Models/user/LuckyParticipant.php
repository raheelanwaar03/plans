<?php

namespace App\Models\user;

use Illuminate\Database\Eloquent\Model;

class LuckyParticipant extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'lucky_draw_id',
        'item_id',
        'item_price',
        'image'
    ];
}
