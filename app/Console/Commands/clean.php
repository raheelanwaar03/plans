<?php

namespace App\Console\Commands;

use App\Models\admin\Wallet;
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
        $tokenPrice->vip_fees = 2000;
        $tokenPrice->vip_price = 5;
        $tokenPrice->save();
        $this->info('App cleaned and initialized successfully.');

        // add wallet
        $wallet = new Wallet();
        $wallet->name = 'Saad';
        $wallet->number = '03032211441';
        $wallet->wallet = 'easyPaisa';
        $wallet->premium_name = 'saad';
        $wallet->premium_number = '03032211442';
        $wallet->premium_wallet = 'JazzCash';
        $wallet->kyc_name = 'saad';
        $wallet->kyc_number = '03032211443';
        $wallet->kyc_wallet = 'NayaPay';
        $wallet->lucky_name = 'saad';
        $wallet->lucky_number = '03032211444';
        $wallet->lucky_wallet = 'SadaPay';
        $wallet->vip_name = 'saad';
        $wallet->vip_number = '093432234545';
        $wallet->vip_wallet = 'Allied Bank';
        $wallet->binance_wallet = 'Bep20';
        $wallet->binance_address = 'asdfaskldfashdaiguadfasdf';
        $wallet->email = 'pigeonofficial6@gmail.com';
        $wallet->save();
    }
}
