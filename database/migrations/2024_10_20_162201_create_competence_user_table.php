<?php

use App\Models\Competence;
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
        Schema::create('competence_user', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->foreignIdFor(\App\Models\User::class)->references('id')->on('users')->onDelete('cascade');
            $table->foreignIdFor(Competence::class)->references('id')->on('competences')->onDelete('cascade');
            $table->foreignIdFor(Tenant::class)->references('id')->on('tenants')->onDelete('cascade');

            $table->index(['tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competence_user');
    }
};
