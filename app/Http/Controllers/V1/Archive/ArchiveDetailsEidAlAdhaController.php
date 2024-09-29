<?php

namespace App\Http\Controllers\V1\Archive;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Archive\EidAlAdhaArchiveIndexResource;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class ArchiveDetailsEidAlAdhaController extends Controller implements HasMiddleware
{
    public function __invoke(Archive $archive): Response
    {
        return Inertia::render('Tenant/archive/details/eid-al-adha/EidAlAdhaIndexArchiveDetailsPage', [
            'archive' => ['id' => $archive->id, 'date' => $archive->created_at->year],
            'families' => EidAlAdhaArchiveIndexResource::collection(
                $archive->listFamilies()
                    ->with([
                        'zone:id,name',
                        'branch:id,name',
                        'sponsor:id,phone_number,family_id,first_name,last_name',
                    ])
                    ->withCount('orphans')
                    ->paginate(request()->integer('perPage', 10))
            ),
            'params' => getParams(),
        ]);
    }
    public static function middleware()
    {
        return ['can:view_archive'];
    }
}
