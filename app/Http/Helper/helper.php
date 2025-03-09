<?php

use App\Models\User;
use App\Models\user\History;
use Carbon\Carbon;

function total_users()
{
    $users = User::count();
    return $users;
}

function tokens()
{
    $tokens = History::where('user_id', auth()->user()->id)->where('type', '!=', 'Mine')->whereDate('created_at',Carbon::today())->get();
    $total_token = 0;
    foreach($tokens as $token)
    {
        $total_token += $token->amount;
    }
    return $total_token;
}
