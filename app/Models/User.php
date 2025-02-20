<?php

namespace App\Models;

use App\Enums\ColorScheme;
use App\Enums\FontSize;
use App\Enums\Layout;
use App\Enums\Theme;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class User extends Authenticatable
{
    use BelongsToTenant, HasApiTokens, HasFactory, HasRoles, HasUuids, Notifiable, Searchable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'zone_id',
        'branch_id',
        'gender',
        'address',
        'qualification',
        'created_by',
        'deleted_by',
        'tenant_id',
        'location',
        'workplace',
        'academic_level_id',
        'function',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(static function (User $user): void {
            $user->settings()->create([
                'theme' => Theme::ENIGMA->value,
                'color_scheme' => ColorScheme::THEME_1->value,
                'layout' => Layout::SIDE_MENU->value,
                'appearance' => 'light',
                'locale' => 'ar',
                'font_size' => FontSize::FONT_SIZE_BASE->value,
                'tenant_id' => $user->tenant_id,
                'notifications' => [
                    'families_changes' => true,
                    'branches_and_zones_changes' => true,
                    'schools_and_lessons_changes' => true,
                    'occasions_saves' => true,
                    'financial_changes' => true,
                    'association_changes' => true,
                ],
            ]);
        });

        static::creating(function ($model): void {
            if (auth()->id()) {
                $model->created_by = auth()->id();
            }
        });

        static::softDeleted(function ($model): void {
            if (auth()->id()) {
                $model->deleted_by = auth()->id();

                $model->save();
            }
        });
    }

    public function settings(): HasOne
    {
        return $this->hasOne(Settings::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function searchableAs(): string
    {
        return 'users';
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['roles', 'zone', 'branch', 'academicLevel', 'committees', 'competences']);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'zone' => [
                'id' => $this->zone_id,
                'name' => $this->zone?->name,
            ],
            'branch' => [
                'id' => $this->branch_id,
                'name' => $this->branch?->name,
            ],
            'academic_level' => [
                'id' => $this->academic_level_id,
                'level' => $this->academicLevel?->level,
                'phase' => $this->academicLevel?->phase,
            ],
            'committees' => $this->committees->pluck('name')->toArray(),
            'competences' => $this->competences->pluck('name')->toArray(),
            'roles' => $this->roles->pluck('name')->toArray(),
            'tenant_id' => $this->tenant_id,
            'created_at' => $this->created_at,
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

    public function competences(): BelongsToMany
    {
        return $this->belongsToMany(Competence::class)->using(CompetenceUser::class);
    }

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(
            AcademicLevel::class,
            'academic_level_id'
        );
    }

    public function committees(): BelongsToMany
    {
        return $this->belongsToMany(Committee::class)->using(CommitteeUser::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'location' => 'array',
        ];
    }
}
