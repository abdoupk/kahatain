<?php

namespace App\Models;

use App\Enums\ColorScheme;
use App\Enums\FontSize;
use App\Enums\Layout;
use App\Enums\Theme;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $phone
 * @property string|null $address
 * @property array<array-key, mixed>|null $location
 * @property string|null $workplace
 * @property string|null $function
 * @property string|null $zone_id
 * @property string|null $branch_id
 * @property string $email
 * @property string|null $gender
 * @property string|null $qualification
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string $tenant_id
 * @property string|null $academic_level_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property-read AcademicLevel|null $academicLevel
 * @property-read Branch|null $branch
 * @property-read CompetenceUser|CommitteeUser|null $pivot
 * @property-read Collection<int, Committee> $committees
 * @property-read int|null $committees_count
 * @property-read Collection<int, Competence> $competences
 * @property-read int|null $competences_count
 * @property-read User|null $creator
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Settings|null $settings
 * @property-read Tenant $tenant
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read Zone|null $zone
 *
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User onlyTrashed()
 * @method static Builder<static>|User permission($permissions, $without = false)
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static Builder<static>|User whereAcademicLevelId($value)
 * @method static Builder<static>|User whereAddress($value)
 * @method static Builder<static>|User whereBranchId($value)
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereCreatedBy($value)
 * @method static Builder<static>|User whereDeletedAt($value)
 * @method static Builder<static>|User whereDeletedBy($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereFirstName($value)
 * @method static Builder<static>|User whereFunction($value)
 * @method static Builder<static>|User whereGender($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereLastName($value)
 * @method static Builder<static>|User whereLocation($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User wherePhone($value)
 * @method static Builder<static>|User whereQualification($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereTenantId($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @method static Builder<static>|User whereWorkplace($value)
 * @method static Builder<static>|User whereZoneId($value)
 * @method static Builder<static>|User withTrashed()
 * @method static Builder<static>|User withoutPermission($permissions)
 * @method static Builder<static>|User withoutRole($roles, $guard = null)
 * @method static Builder<static>|User withoutTrashed()
 *
 * @mixin Eloquent
 */
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
