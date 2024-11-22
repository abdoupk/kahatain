<?php

use App\Models\Subject;
use App\Models\Tenant;
use App\Models\Transcript;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_transcripts', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->integer(Subject::class);
            $table->float('rate');
            $table->foreignUuid(Tenant::class);
            $table->string(Transcript::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_transcripts');
    }
};
