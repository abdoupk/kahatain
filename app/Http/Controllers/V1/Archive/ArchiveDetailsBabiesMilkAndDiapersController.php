<?php

namespace App\Http\Controllers\V1\Archive;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Occasions\BabyMilkAndDiapersResource;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class ArchiveDetailsBabiesMilkAndDiapersController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_archive'];
    }

    public function __invoke(Archive $archive): Response
    {
        return Inertia::render(
            'Tenant/archive/details/babies-milk-and-diapers/BabiesMilkAndDiapersArchiveDetailsPage',
            [
                'archive' => [
                    'id' => $archive->id,
                    'date' => $archive->created_at
                        ->translatedFormat('F Y'),
                ],
                'orphans' => BabyMilkAndDiapersResource::collection(
                    $archive->listBabies()
                        ->with(['babyMilk:id,name', 'diapers:id,name'])
                        ->paginate(request()->integer('perPage', 10))
                ),
                'params' => getParams(),
            ]
        );
    }
}
