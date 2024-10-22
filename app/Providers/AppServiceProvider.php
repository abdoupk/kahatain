<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Carbon\Carbon;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::usePrefetchStrategy('waterfall', ['concurrently' => 3]);

        JsonResource::withoutWrapping();

        Carbon::setLocale(config('app.locale').'_DZ');

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Relation::morphMap([
            'tenant' => 'App\Models\Tenant',
            'domain' => 'App\Models\Domain',
            'user' => 'App\Models\User',
            'orphan' => 'App\Models\Orphan',
            'sponsor' => 'App\Models\Sponsor',
            'family' => 'App\Models\Family',
            'baby' => 'App\Models\Baby',
            'settings' => 'App\Models\Settings',
        ]);

        Str::macro('domain', function (?string $domain): string {
            if (is_null($domain)) {
                return '.'.config('tenancy.central_domains')[0];
            }
            $domain = preg_replace(
                '/[^a-zA-Z\d\s-]|^\d+|([a-zA-Z-])\d+(?=[a-zA-Z-\s])/',
                '$1',
                Str::slug($domain, language: app()->getLocale())
            );

            // Replace multiple spaces with a single hyphen
            $domain = preg_replace('/\s+/', '-', (string) $domain);

            // Replace multiple hyphens with a single hyphen
            $domain = preg_replace('/--+|^-+/', '-', (string) $domain);

            // Remove trailing digits after a hyphen
            $domain = preg_replace('/(-\d+)+$/', '$1', (string) $domain);

            // Remove hyphens before digits
            $domain = preg_replace('/-(?=\d+)/', '', (string) $domain);

            return trim((string) $domain, '-').
                '.'.config('tenancy.central_domains')[0];
        });

        Gate::before(static function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        Model::preventLazyLoading(! $this->app->isProduction());

        Model::shouldBeStrict(! $this->app->isProduction());

        Model::handleLazyLoadingViolationUsing(function ($model, $relation): void {

            $class = get_class($model);

            ray()->notify("Attempted to lazy load [{$relation}] on model [{$class}].");

        });
    }
}
