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
        Schema::create('general_setting', function (Blueprint $table) {
            $table->id('general_setting_id');
            $table->string('general_setting_text')->nullable();
            $table->string('general_setting_logo')->nullable();
            $table->string('general_setting_address')->nullable();
            $table->string('general_setting_phone')->nullable();
            $table->string('general_setting_email')->nullable();
            $table->string('general_setting_facebook')->nullable();
            $table->string('general_setting_linkedin')->nullable();
            $table->string('general_setting_youtube')->nullable();
            $table->string('general_setting_twitter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_setting');
    }
};
