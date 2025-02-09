<?php

namespace App\Providers;

use App\Models\Baby;
use App\Models\Domain;
use App\Models\Family;
use App\Models\Income;
use App\Models\Orphan;
use App\Models\PersonalAccessToken;
use App\Models\School;
use App\Models\Settings;
use App\Models\Sponsor;
use App\Models\Tenant;
use App\Models\University;
use App\Models\UniversitySpeciality;
use App\Models\User;
use App\Models\VocationalTrainingCenter;
use App\Models\VocationalTrainingSpeciality;
use Carbon\Carbon;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
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
        JsonResource::withoutWrapping();

        Carbon::setLocale(config('app.locale').'_DZ');

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Relation::morphMap([
            'tenant' => Tenant::class,
            'university_speciality' => UniversitySpeciality::class,
            'vocational_training_speciality' => VocationalTrainingSpeciality::class,
            'domain' => Domain::class,
            'user' => User::class,
            'orphan' => Orphan::class,
            'sponsor' => Sponsor::class,
            'family' => Family::class,
            'baby' => Baby::class,
            'settings' => Settings::class,
            'income' => Income::class,
            'vocational_training_center' => VocationalTrainingCenter::class,
            'school' => School::class,
            'university' => University::class,
        ]);

        Str::macro('domain', function (?string $domain): string {
            if (is_null($domain)) {
                return '.'.config('tenancy.central_domains')[0];
            }
            $domain = preg_replace(
                '/[^a-zA-Z\d\s-]|^\d+|([a-zA-Z-])\d+(?=[a-zA-Z\-\s])/',
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

        Gate::before(static fn($user) => $user->hasRole('super_admin') ? true : null);

        Model::preventLazyLoading(! $this->app->isProduction());

        Model::shouldBeStrict(! $this->app->isProduction());

        Model::handleLazyLoadingViolationUsing(function ($model, $relation): void {
            if (in_array($this->app->environment(), ['local', 'staging'])) {
                $full_trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, limit: 6);

                $trace = array_pop($full_trace);

                $file_parts = explode('/', $trace['file']);

                $file = array_pop($file_parts);

                $class = $model::class;

                ray()->notify("Attempted to lazy load [$relation] on [line:{$trace['line']}] in [$file] for model [$class].");
            }
        });
    }
}
