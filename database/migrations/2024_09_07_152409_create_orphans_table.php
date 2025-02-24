<?php

use App\Models\AcademicLevel;
use App\Models\Family;
use App\Models\Sponsor;
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
        Schema::create('orphans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date')->index('idx_orphans_birth_date');
            $table->string('family_status')->nullable()->index('idx_orphans_family_status');
            $table->string('health_status')->nullable()->index('idx_orphans_health_status');
            $table->foreignIdFor(AcademicLevel::class)->nullable()->index('idx_orphans_academic_level');
            $table->string('shoes_size')->nullable()->index('idx_orphans_shoes_size');
            $table->string('pants_size')->nullable()->index('idx_orphans_pants_size');
            $table->string('shirt_size')->nullable()->index('idx_orphans_shirt_size');
            $table->string('gender');
            $table->float('income')->nullable();
            $table->boolean('is_handicapped');
            $table->boolean('is_unemployed');
            $table->string('ccp')->nullable();
            $table->float('academic_average')->nullable();
            $table->string('phone_number')->nullable();
            $table->uuid('institution_id')->nullable();
            $table->string('institution_type')->nullable();
            $table->integer('speciality_id')->nullable();
            $table->string('speciality_type')->nullable();
            $table->text('note')->nullable()->index('idx_orphans_note');
            $table->foreignIdFor(Tenant::class)->index('idx_orphans_tenant_id');
            $table->foreignIdFor(Family::class)->index('idx_orphans_family_id');
            $table->foreignIdFor(Sponsor::class);
            $table->foreignIdFor(\App\Models\User::class, 'created_by')->index('idx_orphans_created_by');
            $table->foreignIdFor(\App\Models\User::class, 'deleted_by')->nullable()->index('idx_orphans_deleted_by');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id'], 'idx_orphans_id');
            $table->index(['first_name', 'last_name'], 'idx_orphans_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orphans');
    }
};
