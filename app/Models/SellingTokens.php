<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellingTokens extends Model
{
    // make fillable
    protected $fillable = [
        'user_id',
        'email',
        'phoneNo',
        'title',
        'amount',
        'status',
        'screenShot'
    ];

}
