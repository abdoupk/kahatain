<?php

namespace App\Http\Controllers\V1\Archive;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Archive\RamadanBasketArchiveIndexResource;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class ArchiveDetailsRamadanBasketController extends Controller implements HasMiddleware
{
    public function __invoke(Archive $archive): Response
    {
        return Inertia::render('Tenant/archive/details/ramadan-basket/RamadanBasketArchiveDetailsPage', [
            'archive' => [
                'id' => $archive->id,
                'date' => $archive->created_at->year,
            ],
            'families' => RamadanBasketArchiveIndexResource::collection($archive->listFamilies()
                ->with([
                    'sponsor:id,phone_number,family_id,first_name,last_name',
                    'zone:id,name',
                    'branch:id,name',
                ])
                ->withCount('orphans')
                ->paginate(request()->integer('perPage', 10))),
            'params' => getParams(),
        ]);
    }

    public static function middleware()
    {
        return ['can:view_archive'];
    }
}
