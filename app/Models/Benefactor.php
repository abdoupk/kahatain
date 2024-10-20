<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Benefactor extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'tenant_id',
    ];
}
