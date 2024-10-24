<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class competence extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'name',
        'tenant_id',
    ];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
            'tenant_id' => $this->tenant_id,
        ];
    }

    public function searchableAs(): string
    {
        return 'competences';
    }
}
