<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class clean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to clean the app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('migrate:fresh');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@email.com';
        $user->referral = 'default';
        $user->balance = 10.00;
        $user->password = Hash::make('asdfasdf');
        $user->status = 'active';
        $user->role = 'admin';
        $user->save();

        $user = new User();
        $user->name = 'User';
        $user->email = 'user@gmail.com';
        $user->referral = 'default';
        $user->balance = 100.00;
        $user->password = Hash::make('asdfasdf');
        $user->status = 'active';
        $user->role = 'user';
        $user->save();
    }
}
