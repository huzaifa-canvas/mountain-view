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
        Schema::create('cart', function (Blueprint $table) {
            $table->id('cart_id');
            $table->string('session_id');
            $table->foreignId('listings_id')->constrained('listings', 'listings_id')->onDelete('cascade');
            $table->string('cart_laundry');
            $table->string('cart_check_in');
            $table->string('cart_check_out');
            $table->string('cart_pets');
            $table->string('cart_rooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
