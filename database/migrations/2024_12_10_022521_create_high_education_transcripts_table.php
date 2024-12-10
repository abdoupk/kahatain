<?php

use App\Models\AcademicLevel;
use App\Models\Orphan;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('high_education_transcripts', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->enum('semester', ['first_semester', 'second_semester']);
            $table->foreignIdFor(Orphan::class);
            $table->foreignIdFor(Tenant::class);
            $table->foreignIdFor(AcademicLevel::class);
            $table->timestamps();
        });
    }
};
