<?php

use App\Http\Controllers\V1\SiteSettings\DownloadExportedDataController;
use App\Http\Controllers\V1\SiteSettings\ExportFullDataController;
use App\Http\Controllers\V1\SiteSettings\SiteSettingUpdateAwardedInfosController;
use App\Http\Controllers\V1\SiteSettings\SiteSettingUpdateInfosController;
use App\Http\Controllers\V1\SiteSettings\UpdateCalculationWeightsController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('site-settings')->name('site-settings.')->group(function (): void {
    Route::patch(
        'update-infos',
        SiteSettingUpdateInfosController::class
    )
        ->name('update-infos')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::patch(
        'update-awarded-infos',
        SiteSettingUpdateAwardedInfosController::class
    )
        ->name('update-awarded-infos')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::patch(
        'update-calculation-weights',
        UpdateCalculationWeightsController::class
    )
        ->name('update-calculation-weights');

    Route::post(
        'export-data',
        ExportFullDataController::class
    )
        ->name('export-data');

    Route::get(
        'download-data',
        DownloadExportedDataController::class
    )
        ->name('download-data');
});
