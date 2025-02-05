<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Sponsor extends Model implements HasMedia
{
    use BelongsToTenant, HasFactory, HasUuids, InteractsWithMedia, Searchable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'sponsor_type',
        'birth_date',
        'father_name',
        'mother_name',
        'birth_certificate_number',
        'academic_level_id',
        'function',
        'is_unemployed',
        'health_status',
        'diploma',
        'ccp',
        'gender',
        'created_by',
        'deleted_by',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model): void {
            if (auth()->id()) {
                $model->created_by = auth()->id();
            }
        });

        static::softDeleted(function ($model): void {
            if (auth()->id()) {
                $model->deleted_by = auth()->id();
            }
        });
    }

    public function searchableAs(): string
    {
        return 'sponsors';
    }

    public function incomes(): HasOne
    {
        return $this->hasOne(Income::class);
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['incomes', 'academicLevel', 'orphans', 'family']);
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->getName(),
            'phone_number' => $this->phone_number,
            'sponsor_type' => $this->sponsor_type,
            'birth_date' => (int) strtotime($this->birth_date),
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'birth_certificate_number' => $this->birth_certificate_number,
            'academic_level_id' => $this->academic_level_id,
            'income' => (float) $this->incomes?->total_income,
            'orphans_count' => $this->orphans?->count(),
            'academic_level' => [
                'id' => $this->academic_level_id,
                'i_id' => $this->academicLevel?->i_id,
                'level' => $this->academicLevel?->level,
                'phase' => $this->academicLevel?->phase,
            ],
            'family' => [
                'id' => $this->family_id,
                'income_rate' => $this->family?->income_rate,
            ],
            'function' => $this->function,
            'health_status' => $this->health_status,
            'diploma' => $this->diploma,
            'ccp' => $this->ccp,
            'gender' => $this->gender,
            'tenant_id' => $this->tenant_id,
            'created_at' => strtotime($this->created_at),
        ];
    }

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function orphans(): HasMany
    {
        return $this->hasMany(Orphan::class);
    }

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(AcademicLevel::class, 'academic_level_id');
    }

    public function formattedPhoneNumber(): string
    {
        return formatPhoneNumber($this->phone_number);
    }

    public function deleteWithRelations(): void
    {
        $this->unsearchable();

        $needs = $this->needs();

        $needs->unsearchable();

        $needs->update([
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
        ]);

        $this->delete();
    }

    public function needs(): MorphMany
    {
        return $this->morphMany(Need::class, 'needable');
    }

    public function forceDeleteWithRelations(): void
    {
        $this->unsearchable();

        $needs = $this->needs();

        $needs->unsearchable();

        $needs->forceDelete();

        $this->forceDelete();
    }

    public function restoreWithRelations(): void
    {
        $this->searchable();

        $this->restore();

        $needs = $this->needs()->withTrashed();

        $needs->searchable();

        $needs->restore();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->nonOptimized();
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }
}
