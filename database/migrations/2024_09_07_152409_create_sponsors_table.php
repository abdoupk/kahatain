<?php

use App\Enums\SponsorType;
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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('phone_number');
            $table->enum('sponsor_type', array_map(fn ($type) => $type->value, SponsorType::cases()));
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->text('father_name')->nullable();
            $table->text('mother_name')->nullable();
            $table->text('birth_certificate_number')->nullable();
            $table->foreignIdFor(AcademicLevel::class)->nullable();
            $table->text('function')->nullable();
            $table->text('health_status')->nullable();
            $table->text('diploma')->nullable();
            $table->boolean('is_unemployed');
            $table->text('ccp')->nullable();
            $table->uuid('family_id');
            $table->uuid('tenant_id')->index('idx_sponsors_tenant_id');
            $table->uuid('created_by')->index('idx_sponsors_created_by');
            $table->uuid('deleted_by')->nullable()->index('idx_sponsors_deleted_by');
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
