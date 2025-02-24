<?php

use App\Models\Lesson;
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
        Schema::create('event_occurrences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->ForeignIdFor(Lesson::class, 'lesson_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Event::class);
            $table->foreignIdFor(Tenant::class);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_occurrences');
    }
};
