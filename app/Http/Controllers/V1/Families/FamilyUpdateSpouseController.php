<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Families\FamilySpouseUpdateRequest;
use App\Jobs\V1\Family\FamilyUpdatedJob;
use App\Models\Spouse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class FamilyUpdateSpouseController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_families'];
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function __invoke(FamilySpouseUpdateRequest $request, Spouse $spouse)
    {
        $spouse->update($request->except('death_certificate_file'));

        addToMediaCollection($spouse, $request->validated('death_certificate_file'), 'death_certificate_files');

        dispatch(new FamilyUpdatedJob($spouse->load('family')->family, auth()->user()));

        return response('', 201);
    }
}
