<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Transcript extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'trimester',
        'average',
        'orphan_id',
        'tenant_id',
    ];
}
