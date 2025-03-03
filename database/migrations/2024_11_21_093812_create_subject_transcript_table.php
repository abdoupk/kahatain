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
        Schema::create('subject_transcript', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->foreignIdFor(Subject::class);
            $table->float('grade')->nullable();
            $table->foreignIdFor(Tenant::class);
            $table->foreignIdFor(Transcript::class);

            $table->index(['tenant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_transcript');
    }
};
