<?php

namespace App\Console\Commands;

use App\Models\TokenPrice;
use App\Models\User;
use App\Models\user\Links;
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
        $user->email = 'admin@gmail.com';
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

        // adding task links

        $link = new Links();
        $link->title = 'Towel Info';
        $link->link = 'https://towelinfo.com';
        $link->amount = 2;
        $link->save();

        $link = new Links();
        $link->title = 'All Series Hub';
        $link->link = 'https://allserieshub.com';
        $link->amount = 2;
        $link->save();

        $link = new Links();
        $link->title = 'AE Recipes';
        $link->link = 'https://aerecipes.com';
        $link->amount = 2;
        $link->save();

        $link = new Links();
        $link->title = 'Service SH';
        $link->link = 'https://servicesh.xyz';
        $link->amount = 2;
        $link->save();

        $link = new Links();
        $link->title = 'Earbuds U';
        $link->link = 'https://earbudsu.com';
        $link->amount = 2;
        $link->save();

        $link = new Links();
        $link->title = 'Name Mean';
        $link->link = 'https://namemean.xyz';
        $link->amount = 2;
        $link->save();

        // adding token price
        $tokenPrice = new TokenPrice();
        $tokenPrice->price = 1;
        $tokenPrice->selling_price = 2;
        $tokenPrice->buying_price = 3;
        $tokenPrice->save();
        $this->info('App cleaned and initialized successfully.');
    }
}
