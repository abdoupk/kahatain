<?php

use App\Models\Benefactor;
use App\Models\Tenant;
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
            $table->foreignIdFor(Benefactor::class);
            $table->text('recipientable_type');
            $table->uuid('recipientable_id');
            $table->string('sponsorship_type');
            $table->json('shop')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'created_by');
            $table->foreignIdFor(\App\Models\User::class, 'deleted_by')->nullable();
            $table->dateTime('until')->nullable();
            $table->foreignIdFor(Tenant::class);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id']);
        });
    }
};
