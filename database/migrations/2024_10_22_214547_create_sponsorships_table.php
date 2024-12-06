<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->float('amount');
            $table->uuid('benefactor_id');
            $table->text('recipientable_type');
            $table->uuid('recipientable_id');
            $table->string('sponsorship_type');
            $table->json('shop')->nullable();
            $table->uuid('created_by');
            $table->uuid('deleted_by')->nullable();
            $table->dateTime('until')->nullable();
            $table->uuid('tenant_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
