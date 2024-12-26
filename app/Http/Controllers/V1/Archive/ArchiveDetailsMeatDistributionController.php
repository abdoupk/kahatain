<?php

namespace App\Http\Controllers\V1\Archive;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Archive\MeatDistributionArchiveIndexResource;
use App\Models\Archive;
use Inertia\Inertia;
use Inertia\Response;

class ArchiveDetailsMeatDistributionController extends Controller
{
    public function __invoke(Archive $archive): Response
    {
        return Inertia::render('Tenant/archive/details/meat-distribution/MeatDistributionIndexArchiveDetailsPage', [
            'archive' => ['id' => $archive->id, 'date' => $archive->created_at->translatedFormat('j'.__('glue').'F Y')],
            'families' => MeatDistributionArchiveIndexResource::collection($archive->listFamilies()
                ->with([
                    'zone:id,name',
                    'branch:id,name',
                    'sponsor:id,phone_number,family_id,first_name,last_name',
                ])
                ->withCount('orphans')
                ->paginate(request()->integer('perPage', 10))),
            'params' => getParams(),
        ]);
    }
}
