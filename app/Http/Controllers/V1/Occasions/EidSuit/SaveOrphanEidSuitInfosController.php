<?php

namespace App\Http\Controllers\V1\Occasions\EidSuit;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Occasions\SaveOrphanEidSuitInfosRequest;
use App\Models\Orphan;
use Illuminate\Http\Response;

class SaveOrphanEidSuitInfosController extends Controller
{
    public function __invoke(SaveOrphanEidSuitInfosRequest $request, Orphan $orphan): Response
    {
        $orphan->eidSuit()->updateOrCreate(
            ['orphan_id' => $orphan->id],
            $request->validated()
        );

        $orphan->searchable();

        return response('', 201);
    }
}
