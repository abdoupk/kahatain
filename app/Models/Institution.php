<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Institution extends Model
{
    use BelongsToTenant, HasUuids;

    protected $fillable = ['institutionable_id', 'institutionable_type'];

    public function institutionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function orphans(): HasMany
    {
        return $this->hasMany(Orphan::class);
    }
}
