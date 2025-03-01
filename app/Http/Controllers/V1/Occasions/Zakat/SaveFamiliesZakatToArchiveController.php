<?php

namespace App\Http\Controllers\V1\Occasions\Zakat;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Occasions\SaveZakatToArchiveRequest;
use App\Jobs\V1\Occasion\ZakatFamiliesListSavedJob;
use App\Models\Archive;
use App\Models\FamilyZakat;
use App\Models\Finance;
use DB;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Str;
use Throwable;

class SaveFamiliesZakatToArchiveController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:save_occasions'];
    }

    /**
     * @throws Throwable
     */
    public function __invoke(SaveZakatToArchiveRequest $request): Response
    {
        $amount = (float) $request->amount / count($request->families);

        DB::transaction(function () use ($request, $amount): void {
            Finance::create([
                'specification' => 'zakat',
                'date' => now(),
                'amount' => -1 * (float) $request->amount,
            ]);

            $data = [];

            foreach ($request->families as $family) {
                $data[] = [
                    'id' => Str::uuid(),
                    'family_id' => $family,
                    'amount' => $amount,
                    'zakat_id' => $request->zakat_id,
                    'tenant_id' => tenant('id'),
                ];
            }

            FamilyZakat::insert($data);

            DB::table('families')
                ->whereIn('id', $request->families)
                ->update(['aggregate_zakat_benefit' => DB::raw('aggregate_zakat_benefit + '.$amount)]);

            $archive = Archive::create([
                'occasion' => 'zakat',
                'saved_by' => auth()->user()->id,
                'metadata' => [
                    'amount' => $request->amount,
                    'zakat_id' => $request->zakat_id,
                    'families_count' => count($request->families),
                ],
            ]);

            $families = $archive->families();

            $families->syncWithPivotValues($request->families, ['tenant_id' => tenant('id')]);

            $families->searchable();

            dispatch(new ZakatFamiliesListSavedJob($archive, auth()->user()));
        });

        return response('', 204);
    }
}
