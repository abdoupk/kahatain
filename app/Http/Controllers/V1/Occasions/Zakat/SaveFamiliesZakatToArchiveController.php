<?php

namespace App\Http\Controllers\V1\Occasions\Zakat;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Occasions\SaveZakatToArchiveRequest;
use App\Jobs\V1\Occasion\ZakatFamiliesListSavedJob;
use App\Models\Archive;
use App\Models\Family;
use App\Models\FamilyZakat;
use App\Models\Finance;
use DB;
use Illuminate\Http\Response;
use Str;
use Throwable;

class SaveFamiliesZakatToArchiveController extends Controller
{
    /**
     * @throws Throwable
     */
    public function __invoke(SaveZakatToArchiveRequest $request): Response
    {
        $amount = (float) $request->amount / count($request->families);

        $data = Family::whereIn('id', $request->families)
            ->get()
            ->map(function (Family $family) use ($request, $amount) {
                return [
                    'id' => Str::uuid(),
                    'family_id' => $family->id,
                    'amount' => $amount,
                    'zakat_id' => $request->zakat_id,
                    'tenant_id' => $family->tenant_id,
                ];
            });

        DB::transaction(function () use ($data, $request, $amount) {
            FamilyZakat::insert($data->toArray());

            Finance::create([
                'specification' => 'zakat',
                'date' => now(),
                'amount' => -1 * (float) $request->amount,
            ]);

            DB::table('families')
                ->whereIn('id', $request->families)
                ->update(['aggregate_zakat_benefit' => DB::raw('aggregate_zakat_benefit + '.$amount)]);

            $archive = Archive::create([
                'occasion' => 'zakat',
                'saved_by' => auth()->user()->id,
            ]);

            $archive->families()->syncWithPivotValues($request->families, ['tenant_id' => tenant('id')]);

            dispatch(new ZakatFamiliesListSavedJob($archive, auth()->user()));
        });

        return response('', 204);
    }
}
