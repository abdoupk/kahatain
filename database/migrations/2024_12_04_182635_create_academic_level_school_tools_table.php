<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_level_school_tools', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->tinyInteger('qty');
            $table->foreignUuid('academic_level_id')->constrained('academic_levels');
            $table->foreignId('school_tool_id');
            $table->timestamps();
        });
    }
};
