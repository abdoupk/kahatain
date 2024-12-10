<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Auth\AuthenticatedSessionController;
use App\Http\Controllers\V1\CitySearchController;
use App\Http\Controllers\V1\Trash\TrashIndexController;
use App\Http\Controllers\V1\UploadFileController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function (): void {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login')
        ->middleware('guest');

    Route::get('/', fn () => redirect()->route('tenant.dashboard'));

    Route::name('tenant.')->prefix('/dashboard/')->group(function (): void {
        Route::middleware('guest')->group(function (): void {
            Route::post(
                'login',
                [AuthenticatedSessionController::class, 'store']
            );
        });

        Route::middleware('guest')->group(function (): void {
            Route::post(
                'login',
                [AuthenticatedSessionController::class, 'store']
            )->name('login');
        });

        Route::middleware('auth')->group(function (): void {
            // TODO: remove this
            Route::get('/test', function () {
                return view('pdf.school-tools', [
                    'title' => 'School tools',
                    'data' => generateSchoolTools(),
                ]);
            })->name('test');

            require __DIR__.'/v1/archive.php';

            require __DIR__.'/v1/benefactors.php';

            require __DIR__.'/v1/branches.php';

            require __DIR__.'/v1/college-students.php';

            require __DIR__.'/v1/committees.php';

            require __DIR__.'/v1/dashboard.php';

            require __DIR__.'/v1/families.php';

            require __DIR__.'/v1/financial.php';

            require __DIR__.'/v1/inventory.php';

            require __DIR__.'/v1/lessons.php';

            require __DIR__.'/v1/list.php';

            require __DIR__.'/v1/members.php';

            require __DIR__.'/v1/monthly-sponsorship.php';

            require __DIR__.'/v1/needs.php';

            require __DIR__.'/v1/notifications.php';

            require __DIR__.'/v1/orphans.php';

            require __DIR__.'/v1/profile.php';

            require __DIR__.'/v1/roles.php';

            require __DIR__.'/v1/schools.php';

            require __DIR__.'/v1/settings.php';

            require __DIR__.'/v1/site-settings.php';

            require __DIR__.'/v1/sponsors.php';

            require __DIR__.'/v1/students.php';

            require __DIR__.'/v1/trainees.php';

            require __DIR__.'/v1/transcripts.php';

            require __DIR__.'/v1/vocational-training.php';

            require __DIR__.'/v1/zones.php';

            Route::prefix('projects')->name('occasions.')
                ->group(function (): void {
                    require __DIR__.'/v1/occasions/ramadan-basket.php';

                    require __DIR__.'/v1/occasions/babies-milk-and-diapers.php';

                    require __DIR__.'/v1/occasions/eid-al-adha.php';

                    require __DIR__.'/v1/occasions/eid-suit.php';

                    require __DIR__.'/v1/occasions/monthly-sponsorship.php';

                    require __DIR__.'/v1/occasions/school-entry.php';

                    require __DIR__.'/v1/occasions/zakat.php';

                    require __DIR__.'/v1/occasions/meat-distribution.php';
                });

            Route::get('trash', TrashIndexController::class)->name('trash');

            Route::get('search/cities', CitySearchController::class)->name('cities.search');

            Route::post(
                'logout',
                [AuthenticatedSessionController::class, 'destroy']
            )->name('logout');

            Route::post('upload-file', UploadFileController::class)->name('upload.file');
        });
    });
});
