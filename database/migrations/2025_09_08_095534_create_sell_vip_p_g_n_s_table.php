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
        Schema::create('sell_vip_p_g_n_s', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('pgn_amount');
            $table->string('title');
            $table->string('account');
            $table->string('type');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_vip_p_g_n_s');
    }
};
