<?php

use App\Enums\ColorScheme;
use App\Enums\FontSize;
use App\Enums\Layout;
use App\Enums\Theme;
use App\Models\Tenant;
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
            $table->foreignIdFor(\App\Models\User::class)->index('idx_settings_user_id');
            $table->string('locale');
            $table->enum('theme', array_map(fn ($type) => $type->value, Theme::cases()));
            $table->enum('color_scheme', array_map(fn ($type) => $type->value, ColorScheme::cases()));
            $table->enum('layout', array_map(fn ($type) => $type->value, Layout::cases()));
            $table->enum('appearance', ['light', 'dark']);
            $table->enum('font_size', array_map(fn ($type) => $type->value, FontSize::cases()));
            $table->jsonb('notifications')->nullable();
            $table->foreignIdFor(Tenant::class);
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
