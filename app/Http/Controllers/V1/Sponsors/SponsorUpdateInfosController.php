<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sponsors\SponsorInfosUpdateRequest;
use App\Jobs\V1\Sponsor\SponsorUpdatedJob;
use App\Models\Sponsor;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SponsorUpdateInfosController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_sponsors'];
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function __invoke(SponsorInfosUpdateRequest $request, Sponsor $sponsor)
    {
        $sponsor->update($request->except(['photo', 'diploma_file', 'birth_certificate_file']));

        if ($request->sponsor_type !== $sponsor->sponsor_type) {
            monthlySponsorship($sponsor->load('family')->family);
        }

        $sponsor->orphans->searchable();

        addToMediaCollection($sponsor, $request->diploma_file, 'diploma_files');

        addToMediaCollection($sponsor, $request->birth_certificate_file, 'birth_certificate_files');

        addToMediaCollection($sponsor, $request->photo, 'photos');

        dispatch(new SponsorUpdatedJob($sponsor, auth()->user()));

        return response('', 201);
    }
}
