<?php

namespace App\Models;

use Database\Factories\TenantFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\TenantCollection;

/**
 * @property string $id
 * @property array|null $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, \Stancl\Tenancy\Database\Models\Domain> $domains
 * @property-read int|null $domains_count
 * @property-read Collection<int, Family> $families
 * @property-read int|null $families_count
 * @property-read Collection<int, User> $members
 * @property-read int|null $members_count
 * @property-read Collection<int, PrivateSchool> $schools
 * @property-read int|null $schools_count
 *
 * @method static TenantCollection<int, static> all($columns = ['*'])
 * @method static TenantFactory factory($count = null, $state = [])
 * @method static TenantCollection<int, static> get($columns = ['*'])
 * @method static Builder|Tenant newModelQuery()
 * @method static Builder|Tenant newQuery()
 * @method static Builder|Tenant query()
 * @method static Builder|Tenant whereCreatedAt($value)
 * @method static Builder|Tenant whereData($value)
 * @method static Builder|Tenant whereId($value)
 * @method static Builder|Tenant whereUpdatedAt($value)
 *
 * @property-read Collection<int, Benefactor> $benefactors
 * @property-read int|null $benefactors_count
 * @property-read Collection<int, Branch> $branches
 * @property-read int|null $branches_count
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, Zone> $zones
 * @property-read int|null $zones_count
 *
 * @mixin Eloquent
 */
class Tenant extends BaseTenant implements HasMedia, TenantWithDatabase
{
    use HasDatabase, HasDomains, HasFactory, InteractsWithMedia;

    public static function booted(): void
    {
        static::created(function ($tenant): void {
            $password = bcrypt($tenant->infos['super_admin']['password']);
            $tenant->update([
                'infos' => array_merge($tenant->infos, [
                    'super_admin' => array_merge($tenant->infos['super_admin'], ['password' => $password]),
                ]),
            ]);
        });

        static::creating(function ($tenant): void {
            $tenant->calculation = json_encode(CALCULATION);
        });
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function zones(): HasMany
    {
        return $this->hasMany(Zone::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function schools(): HasMany
    {
        return $this->hasMany(PrivateSchool::class);
    }

    public function benefactors(): HasMany
    {
        return $this->hasMany(Benefactor::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logos')
            ->useFallbackPath(public_path('/images/logo.svg'));
    }
}
