<?php

namespace App\Http\Controllers\V1\Occasions\MeatDistribution;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Occasions\SaveMeatDistributionToArchiveRequest;
use App\Jobs\V1\Occasion\MeatDistributionFamiliesListSavedJob;
use App\Models\Archive;
use DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Throwable;

class SaveFamiliesMeatDistributionToArchiveController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:save_occasions'];
    }

    /**
     * @throws Throwable
     */
    public function __invoke(saveMeatDistributionToArchiveRequest $request)
    {
        DB::transaction(function () use ($request): void {
            $colum = ($request->meat_type === 'red_meat') ? 'aggregate_red_meat_benefit' : 'aggregate_white_meat_benefit';

            DB::table('families')
                ->whereIn('id', $request->families)
                ->update([$colum => DB::raw("$colum + 1")]);

            $archive = Archive::create([
                'occasion' => 'meat_distribution',
                'saved_by' => auth()->user()->id,
            ]);

            $families = $archive->families();

            $families->syncWithPivotValues($request->families, ['tenant_id' => tenant('id')]);

            $families->searchable();

            dispatch(new MeatDistributionFamiliesListSavedJob($archive, auth()->user()));
        });

        return response('', 204);
    }
}
