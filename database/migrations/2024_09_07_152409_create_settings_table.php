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
        Schema::create('settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index('idx_settings_user_id');
            $table->text('locale');
            $table->enum('theme', ['enigma', 'icewall', 'tinker',
                'rubick']);
            $table->enum('color_scheme', ['default', 'theme_1',
                'theme_2', 'theme_3', 'theme_4']);
            $table->enum('layout', ['top_menu', 'simple_menu', 'side_menu']);
            $table->enum('appearance', ['light', 'dark']);
            $table->enum('font_size', ['font_size_xs', 'font_size_sm',
                'font_size_base', 'font_size_lg', 'font_size_xl']);
            $table->jsonb('notifications')->nullable();
            $table->uuid('tenant_id');
            $table->timestamps();

            $table->index(['id'], 'idx_settings_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
