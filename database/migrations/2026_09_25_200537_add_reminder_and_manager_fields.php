<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'reminder_sent_at')) {
                // Stamped when the day-before reminder goes out, so a cron that
                // runs more than once cannot email the same guest twice.
                $table->timestamp('reminder_sent_at')->nullable()->after('checked_out_at');
            }
        });

        Schema::table('general_setting', function (Blueprint $table) {
            if (!Schema::hasColumn('general_setting', 'manager_name')) {
                // The name emails are signed with, so it is not hard-coded
                $table->string('manager_name')->nullable();
            }
            if (!Schema::hasColumn('general_setting', 'manager_title')) {
                $table->string('manager_title')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'reminder_sent_at')) {
                $table->dropColumn('reminder_sent_at');
            }
        });

        Schema::table('general_setting', function (Blueprint $table) {
            foreach (['manager_name', 'manager_title'] as $column) {
                if (Schema::hasColumn('general_setting', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
