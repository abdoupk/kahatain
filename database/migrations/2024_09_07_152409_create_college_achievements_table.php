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
        Schema::create('college_achievements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('orphan_id');
            $table->float('first_semester')->nullable();
            $table->float('second_semester')->nullable();
            $table->text('speciality');
            $table->integer('year');
            $table->text('university')->nullable();
            $table->text('note')->nullable();
            $table->float('average')->nullable();
            $table->uuid('tenant_id');
            $table->foreignIdFor(AcademicLevel::class);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('college_achievements');
    }
};
