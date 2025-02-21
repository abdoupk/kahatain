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
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->uuid('role_id');
            $table->text('model_type');
            $table->foreignIdFor(Tenant::class);
            $table->uuid('model_uuid');

            $table->primary(['role_id', 'model_uuid', 'model_type']);
            $table->index(['model_uuid', 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->index(['tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_roles');
    }
};
