<?php

namespace App\Http\Controllers\V1\Archive;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Archive\ZakatArchiveIndexResource;
use App\Models\Archive;

class ArchiveDetailsZakatController extends Controller
{
    public function __invoke(Archive $archive)
    {
        return inertia('Tenant/archive/details/zakat/ZakatIndexArchiveDetailsPage',
            [
                'archive' => ['id' => $archive->id, 'date' => $archive->created_at->translatedFormat('j'.__('glue').'F Y')],
                'families' => ZakatArchiveIndexResource::collection(
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
                'amount' => $archive->metadata['amount'] ?? 0,
            ]);
    }
}
