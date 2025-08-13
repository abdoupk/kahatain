<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Orphans\OrphanInfosUpdateRequest;
use App\Jobs\V1\Orphan\OrphanUpdatedJob;
use App\Models\Orphan;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class OrphanUpdateInfosController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_orphans'];
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function __invoke(OrphanInfosUpdateRequest $request, Orphan $orphan): ResponseFactory|Application|Response
    {
        $orphan->update([
            ...$request->except(['baby_milk_quantity', 'baby_milk_type', 'diapers_quantity', 'diapers_type', 'photo', 'institution', 'speciality', 'academic_level_id']),
            'academic_level_id' => is_string($request->academic_level_id) ? $request->academic_level_id : $request->get('academic_level_id')['id'] ?? null,
            'institution_id' => $request->institution,
            'speciality_id' => $request->speciality ? $request->speciality['id'] : null,
        ]);

        if (now()->diff($orphan->birth_date)->y < 2) {
            $orphan->babyNeeds()->update($request->only(
                ['baby_milk_quantity',
                    'baby_milk_type',
                    'diapers_quantity',
                    'diapers_type',
                ]
            ));
        }

        monthlySponsorship($orphan->load('family')->family);

        addToMediaCollection($orphan, $request->photo, 'photos');

        dispatch(new OrphanUpdatedJob($orphan, auth()->user()));

        return response('', 201);
    }
}
