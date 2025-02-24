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
        Schema::create('cities', function (Blueprint $table) {
            $table->integer('id')->primary()->index();
            $table->string('commune_name')->index('idx_cities_commune_name');
            $table->string('commune_name_ascii');
            $table->string('daira_name')->index('idx_cities_daira_name');
            $table->string('daira_name_ascii');
            $table->string('wilaya_code', 4)->index('idx_cities_wilaya_code');
            $table->string('wilaya_name')->index('idx_cities_wilaya_name');
            $table->string('wilaya_name_ascii');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('post_code', 5)->index('idx_cities_post_code');

            $table->string('commune_code', 4)->nullable();

            $table->index(['id'], 'idx_cities_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
