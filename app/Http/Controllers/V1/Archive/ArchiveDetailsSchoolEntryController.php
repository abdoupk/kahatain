<?php

namespace App\Http\Controllers\V1\Archive;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Archive\SchoolEntryArchiveIndexResource;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class ArchiveDetailsSchoolEntryController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_archive'];
    }

    public function __invoke(Archive $archive): Response
    {
        return Inertia::render('Tenant/archive/details/school-entry/SchoolEntryArchiveDetailsPage', [
            'archive' => ['id' => $archive->id, 'date' => $archive->created_at->year],
            'orphans' => SchoolEntryArchiveIndexResource::collection(
                $archive->listOrphans()
                    ->with([
                        'academicLevel',
                        'family:id,address,zone_id',
                        'family.zone:id,name',
                    ])
                    ->paginate(request()->integer('perPage', 10))
            ),
            'params' => getParams(),
        ]);
    }
}
