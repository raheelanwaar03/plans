<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->string('wallet');
            $table->string('premium_number');
            $table->string('premium_wallet');
            $table->string('kyc_number');
            $table->string('kyc_wallet');
            $table->string('lucky_number');
            $table->string('lucky_wallet');
            $table->string('vip_number');
            $table->string('vip_wallet');
            $table->string('email');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
