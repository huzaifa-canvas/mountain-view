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
        Schema::table('general_setting', function (Blueprint $table) {
            $table->decimal('loyalty_points_per_dollar', 8, 4)->default(0.2000); // 1 point per $5
            $table->decimal('loyalty_points_redemption_rate', 8, 4)->default(0.1000); // 100 points = $10
            $table->boolean('loyalty_enabled')->default(true);
            $table->string('currency')->default('CAD');
            $table->decimal('tax_rate', 5, 2)->default(15.00);
            $table->string('tax_label')->default('Taxes & fees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_setting', function (Blueprint $table) {
            $table->dropColumn([
                'loyalty_points_per_dollar',
                'loyalty_points_redemption_rate',
                'loyalty_enabled',
                'currency',
                'tax_rate',
                'tax_label'
            ]);
        });
    }
};
