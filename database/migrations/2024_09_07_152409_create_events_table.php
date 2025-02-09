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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->foreignIdFor(Lesson::class, 'lesson_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string('frequency')->nullable();
            $table->integer('interval')->nullable();
            $table->date('until')->nullable();
            $table->string('color')->nullable();
            $table->foreignIdFor(Tenant::class);
            $table->softDeletes();
            $table->timestamps();
            $table->foreignIdFor(\App\Models\User::class, 'created_by');
            $table->foreignIdFor(\App\Models\User::class, 'deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
