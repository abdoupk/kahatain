<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class MemberPreview extends Pivot
{
    use BelongsToTenant, HasFactory, HasUuids;

    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'member_preview';

    protected function casts(): array
    {
        return [
            'user_id' => 'string',
            'preview_id' => 'string',
        ];
    }
}
