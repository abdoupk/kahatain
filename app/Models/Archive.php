<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Archive extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'occasion',
        'tenant_id',
        'saved_by',
        'metadata',
    ];

    public function savedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'saved_by');
    }

    public function families(): MorphToMany
    {
        return $this->morphedByMany(Family::class, 'archiveable');
    }

    public function orphans(): MorphToMany
    {
        return $this->morphedByMany(Orphan::class, 'archiveable');
    }

    public function babies(): MorphToMany
    {
        return $this->morphedByMany(Baby::class, 'archiveable');
    }

    public function listBabies(): HasManyThrough
    {
        return $this->hasManyThrough(
            Baby::class,
            Archiveable::class,
            'archive_id',
            'id',
            'id',
            'archiveable_id'
        )->with('orphan.sponsor');
    }

    public function listOrphans(): HasManyThrough
    {
        return $this->hasManyThrough(
            Orphan::class,
            Archiveable::class,
            'archive_id',
            'id',
            'id',
            'archiveable_id'
        )
            ->with(
                'sponsor:id,first_name,last_name,phone_number,family_id'
            );
    }

    public function listFamilies(): HasManyThrough
    {
        return $this->hasManyThrough(Family::class, Archiveable::class, 'archive_id', 'id', 'id', 'archiveable_id');
    }

    public function searchableAs(): string
    {
        return 'archive';
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'occasion' => [
                'ar' => __($this->occasion, locale: 'ar'),
                'en' => __($this->occasion, locale: 'en'),
                'fr' => __($this->occasion, locale: 'fr'),
            ],
            'saved_by' => [
                'id' => $this->savedBy?->id,
                'name' => $this->savedBy?->getName(),
            ],
            'tenant_id' => $this->tenant_id,
            'created_at' => strtotime($this->created_at),
        ];
    }

    protected function casts(): array
    {
        return [
            'tenant_id' => 'string',
            'saved_by' => 'string',
            'metadata' => 'array',
        ];
    }
}
