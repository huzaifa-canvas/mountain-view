<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A stay now moves through three states in checkout_status:
 * confirmed -> checked_in -> checked_out. Only the arrival timestamp is new;
 * checked_out_at already exists. Bookings recorded before this migration stay
 * on "confirmed" or "checked_out" with a null checked_in_at, which the admin
 * renders as "not recorded" rather than pretending an arrival time it lacks.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders') || Schema::hasColumn('orders', 'checked_in_at')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('checked_in_at')->nullable()->after('checkout_status');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('orders') || !Schema::hasColumn('orders', 'checked_in_at')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('checked_in_at');
        });
    }
};
