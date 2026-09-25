<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * What the booking was worth before and after a date change.
 *
 * Staff can change how long a stay runs, which changes the price, so the
 * timeline has to be able to say how much money moved — not just the dates.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_changes', function (Blueprint $table) {
            if (!Schema::hasColumn('booking_changes', 'from_total')) {
                $table->decimal('from_total', 10, 2)->nullable()->after('to_check_out');
            }
            if (!Schema::hasColumn('booking_changes', 'to_total')) {
                $table->decimal('to_total', 10, 2)->nullable()->after('from_total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('booking_changes', function (Blueprint $table) {
            foreach (['from_total', 'to_total'] as $column) {
                if (Schema::hasColumn('booking_changes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
