<?php

use App\Models\AcademicLevel;
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
        Schema::create('academic_achievements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(AcademicLevel::class)->nullable();
            $table->integer('academic_year')->nullable();
            $table->float('first_trimester')->nullable();
            $table->float('second_trimester')->nullable();
            $table->float('third_trimester')->nullable();
            $table->float('average')->nullable();
            $table->text('note')->nullable();
            $table->uuid('orphan_id');
            $table->uuid('tenant_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_achievements');
    }
};
