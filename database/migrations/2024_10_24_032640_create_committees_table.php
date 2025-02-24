<?php

use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('name');
            $table->text('description');
            $table->foreignIdFor(\App\Models\User::class, 'created_by');
            $table->foreignIdFor(\App\Models\User::class, 'deleted_by')->nullable();
            $table->foreignIdFor(Tenant::class);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id']);
        });
    }
};
