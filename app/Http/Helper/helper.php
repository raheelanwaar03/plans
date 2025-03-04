<?php

use App\Models\User;


function total_users()
{
    $users = User::count();
    return $users;
}
