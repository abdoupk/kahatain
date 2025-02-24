<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

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
