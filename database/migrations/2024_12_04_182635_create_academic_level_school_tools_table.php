<?php

use App\Models\AcademicLevel;
use App\Models\SchoolTool;
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
            $table->foreignIdFor(AcademicLevel::class)->constrained('academic_levels');
            $table->foreignIdFor(SchoolTool::class);
            $table->timestamps();
        });
    }
};
