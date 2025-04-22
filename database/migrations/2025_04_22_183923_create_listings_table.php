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
        Schema::create('listings', function (Blueprint $table) {
            $table->id('listings_id');
            $table->string('listings_slug')->unique();
            $table->string('listings_name');
            $table->decimal('listings_price', 10, 2);
            $table->longtext('listings_points');
            $table->string('listings_img');
            $table->string('listings_extras');
            $table->string('listings_number_of_persons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
