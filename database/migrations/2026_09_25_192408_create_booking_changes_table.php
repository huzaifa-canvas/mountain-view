<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A record of every time a booking's dates were moved.
 *
 * Kept as its own table rather than overwriting a field on the order: the
 * point is to be able to say who moved the stay and what it looked like
 * before, which a single "last changed" column cannot answer.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('booking_changes')) {
            return;
        }

        Schema::create('booking_changes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('changed_by', 20);          // guest | admin
            $table->string('changed_by_name')->nullable();
            $table->date('from_check_in');
            $table->date('from_check_out');
            $table->date('to_check_in');
            $table->date('to_check_out');
            $table->timestamps();

            // Always read back for one booking, newest first
            $table->index(['order_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_changes');
    }
};
