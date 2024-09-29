<?php

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
        Schema::create('orphan_sponsorship', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('orphan_id')->index('idx_orphan_sponsorship_orphan_id');
            $table->boolean('medical_sponsorship')->nullable();
            $table->boolean('university_scholarship')->nullable();
            $table->boolean('association_trips')->nullable();
            $table->boolean('summer_camp')->nullable();
            $table->boolean('eid_suit')->nullable();
            $table->boolean('private_lessons')->nullable();
            $table->boolean('school_bag')->nullable();
            $table->uuid('tenant_id')->index('idx_orphan_sponsorship_tenant_id');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
            $table->timestamp('updated_at')->nullable();

            $table->index(['id'], 'idx_orphan_sponsorship_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orphan_sponsorship');
    }
};
