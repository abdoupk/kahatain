<?php

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
        Schema::create('archiveables', function (Blueprint $table) {
            $table->uuid('archive_id');
            $table->uuid('archiveable_id');
            $table->string('archiveable_type');
            $table->foreignIdFor(Tenant::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archiveables');
    }
};
