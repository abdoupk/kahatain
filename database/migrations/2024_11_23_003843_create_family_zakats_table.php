<?php

use App\Models\Family;
use App\Models\Finance;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_zakats', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->float('amount');
            $table->foreignIdFor(Finance::class, 'zakat_id');
            $table->foreignIdFor(Family::class);
            $table->foreignIdFor(Tenant::class);
        });
    }
};
