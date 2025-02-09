<?php

use App\Models\Committee;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('committee_user', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->foreignIdFor(\App\Models\User::class)->references('id')->on('users')->onDelete('cascade');
            $table->foreignIdFor(Committee::class)->references('id')->on('committees')->onDelete('cascade');
            $table->foreignIdFor(Tenant::class)->references('id')->on('tenants')->onDelete('cascade');
        });
    }
};
