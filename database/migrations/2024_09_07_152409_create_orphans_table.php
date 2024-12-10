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
        Schema::create('orphans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('first_name');
            $table->text('last_name');
            $table->date('birth_date')->index('idx_orphans_birth_date');
            $table->text('family_status')->nullable()->index('idx_orphans_family_status');
            $table->text('health_status')->nullable()->index('idx_orphans_health_status');
            $table->foreignIdFor(AcademicLevel::class)->nullable()->index('idx_orphans_academic_level');
            $table->integer('vocational_training_id')->nullable();
            $table->text('shoes_size')->nullable()->index('idx_orphans_shoes_size');
            $table->text('pants_size')->nullable()->index('idx_orphans_pants_size');
            $table->text('shirt_size')->nullable()->index('idx_orphans_shirt_size');
            $table->text('gender');
            $table->float('income')->nullable();
            $table->boolean('is_handicapped');
            $table->boolean('is_unemployed');
            $table->string('ccp')->nullable();
            $table->float('academic_average')->nullable();
            $table->string('phone_number')->nullable();
            $table->uuid('institution_id')->nullable();
            $table->string('institution_type')->nullable();
            $table->text('note')->nullable()->index('idx_orphans_note');
            $table->uuid('tenant_id')->index('idx_orphans_tenant_id');
            $table->uuid('family_id')->index('idx_orphans_family_id');
            $table->uuid('sponsor_id');
            $table->uuid('created_by')->index('idx_orphans_created_by');
            $table->uuid('deleted_by')->nullable()->index('idx_orphans_deleted_by');
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
