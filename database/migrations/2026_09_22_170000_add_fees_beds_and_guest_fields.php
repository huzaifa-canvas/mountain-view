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
        if (Schema::hasTable('general_setting')) {
            Schema::table('general_setting', function (Blueprint $table) {
                if (!Schema::hasColumn('general_setting', 'pet_fee')) {
                    $table->decimal('pet_fee', 10, 2)->default(25.00);
                }
                if (!Schema::hasColumn('general_setting', 'laundry_fee')) {
                    $table->decimal('laundry_fee', 10, 2)->default(25.00);
                }
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'guest_first_name')) {
                    $table->string('guest_first_name')->nullable();
                }
                if (!Schema::hasColumn('orders', 'guest_last_name')) {
                    $table->string('guest_last_name')->nullable();
                }
                if (!Schema::hasColumn('orders', 'guest_address')) {
                    $table->text('guest_address')->nullable();
                }
                if (!Schema::hasColumn('orders', 'guest_city')) {
                    $table->string('guest_city')->nullable();
                }
                if (!Schema::hasColumn('orders', 'guest_province')) {
                    $table->string('guest_province')->nullable();
                }
                if (!Schema::hasColumn('orders', 'guest_postal_code')) {
                    $table->string('guest_postal_code')->nullable();
                }
                if (!Schema::hasColumn('orders', 'guest_vehicle_number')) {
                    $table->string('guest_vehicle_number')->nullable();
                }
                if (!Schema::hasColumn('orders', 'guest_id_proof')) {
                    $table->string('guest_id_proof')->nullable();
                }
                if (!Schema::hasColumn('orders', 'pet_fee_total')) {
                    $table->decimal('pet_fee_total', 10, 2)->default(0);
                }
                if (!Schema::hasColumn('orders', 'laundry_fee_total')) {
                    $table->decimal('laundry_fee_total', 10, 2)->default(0);
                }
            });
        }

        if (Schema::hasTable('listings')) {
            Schema::table('listings', function (Blueprint $table) {
                if (!Schema::hasColumn('listings', 'listings_number_of_beds')) {
                    $table->integer('listings_number_of_beds')->default(1);
                }
            });
        }

        if (Schema::hasTable('cart')) {
            Schema::table('cart', function (Blueprint $table) {
                if (!Schema::hasColumn('cart', 'cart_laundry_qty')) {
                    $table->integer('cart_laundry_qty')->default(0);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('general_setting')) {
            Schema::table('general_setting', function (Blueprint $table) {
                $table->dropColumn(['pet_fee', 'laundry_fee']);
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn([
                    'guest_first_name',
                    'guest_last_name',
                    'guest_address',
                    'guest_city',
                    'guest_province',
                    'guest_postal_code',
                    'guest_vehicle_number',
                    'guest_id_proof',
                    'pet_fee_total',
                    'laundry_fee_total',
                ]);
            });
        }

        if (Schema::hasTable('listings')) {
            Schema::table('listings', function (Blueprint $table) {
                $table->dropColumn(['listings_number_of_beds']);
            });
        }
    }
};
