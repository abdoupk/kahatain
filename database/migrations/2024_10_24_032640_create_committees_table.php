<?php

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
            $table->uuid('created_by');
            $table->uuid('deleted_by')->nullable();
            $table->uuid('tenant_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
