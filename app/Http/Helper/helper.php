<?php

use App\Models\User;
use App\Models\user\History;

function total_users()
{
    $users = User::count();
    return $users;
}

function tokens()
{
    $token = History::where('user_id', auth()->user()->id)->where('type', '!=', 'Mine')->get();
    $sum = 0;
    foreach($token as $item)
    {
        // sum the amount
        $total = $sum + $item->amount;
    }
    return $total;
}
