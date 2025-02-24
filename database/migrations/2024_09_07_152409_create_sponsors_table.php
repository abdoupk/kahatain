<?php

use App\Enums\SponsorType;
use App\Models\AcademicLevel;
use App\Models\Family;
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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_number');
            $table->enum('sponsor_type', array_map(fn ($type) => $type->value, SponsorType::cases()));
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('birth_certificate_number')->nullable();
            $table->foreignIdFor(AcademicLevel::class)->nullable();
            $table->string('function')->nullable();
            $table->string('health_status')->nullable();
            $table->string('diploma')->nullable();
            $table->boolean('is_unemployed');
            $table->string('ccp')->nullable();
            $table->foreignIdFor(Family::class);
            $table->foreignIdFor(Tenant::class)->index('idx_sponsors_tenant_id');
            $table->foreignIdFor(\App\Models\User::class, 'created_by')->index('idx_sponsors_created_by');
            $table->foreignIdFor(\App\Models\User::class, 'deleted_by')->nullable()->index('idx_sponsors_deleted_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
