<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sponsors\SponsorIncomesUpdateRequest;
use App\Jobs\V1\Sponsor\SponsorUpdatedJob;
use App\Models\Sponsor;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SponsorUpdateIncomesController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_sponsors'];
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function __invoke(SponsorIncomesUpdateRequest $request, Sponsor $sponsor)
    {
        $sponsor->incomes()->update([
            ...$request->only(['incomes.casnos', 'incomes.ccp', 'incomes.cnr', 'incomes.cnas', 'incomes.other_income', 'incomes.pension', 'incomes.account'])['incomes'],
            'total_income' => setTotalIncomeAttribute($request->except(['incomes.bank_file', 'incomes.ccp_file', 'incomes.casnos_file', 'incomes.cnas_file', 'incomes.cnr_file', 'incomes.cnas', 'incomes.casnos', 'incomes.cnr', 'incomes.pension', 'incomes.total_income', 'incomes.id'])['incomes']),
        ]);

        $income = $sponsor->incomes()->first();

        monthlySponsorship($sponsor->load('family')->family);

        addToMediaCollection($income, $request->validated('incomes.bank_file'), 'bank_files');

        addToMediaCollection($income, $request->validated('incomes.ccp_file'), 'ccp_files');

        addToMediaCollection($income, $request->validated('incomes.casnos_file'), 'casnos_files');

        addToMediaCollection($income, $request->validated('incomes.cnas_file'), 'cnas_files');

        addToMediaCollection($income, $request->validated('incomes.cnr_file'), 'cnr_files');

        dispatch(new SponsorUpdatedJob($sponsor, auth()->user()));

        return response('', 201);
    }
}
