<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_levels', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->tinyInteger('i_id');
            $table->string('level');
            $table->string('phase');
            $table->string('phase_key')->nullable();
            $table->json('subject_ids')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_levels');
    }
};
