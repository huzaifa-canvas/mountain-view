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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('listings_id')->nullable()->constrained('listings', 'listings_id')->nullOnDelete();
            $table->string('listing_name');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('rooms')->default(1);
            $table->string('pets')->nullable();
            $table->string('laundry')->nullable();
            $table->decimal('price_per_night', 10, 2);
            $table->integer('nights');
            $table->decimal('item_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
