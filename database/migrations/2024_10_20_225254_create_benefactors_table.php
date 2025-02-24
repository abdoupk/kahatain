<?php

use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('benefactors', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->json('location')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'created_by');
            $table->foreignIdFor(\App\Models\User::class, 'deleted_by')->nullable();
            $table->foreignIdFor(Tenant::class);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id']);
        });
    }
};
