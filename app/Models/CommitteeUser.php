<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CommitteeUser extends Pivot
{
    use HasUuids;

    public $timestamps = false;

    protected $table = 'committee_user';

    protected $fillable = [
        'committee_id',
        'user_id',
        'tenant_id',
    ];

    protected function casts(): array
    {
        return [
            'committee_id' => 'string',
            'user_id' => 'string',
            'tenant_id' => 'string',
        ];
    }
}