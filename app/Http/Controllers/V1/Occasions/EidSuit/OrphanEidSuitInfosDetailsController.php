<?php

namespace App\Http\Controllers\V1\Occasions\EidSuit;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Occasions\EidSuitResource;
use App\Models\Orphan;

class OrphanEidSuitInfosDetailsController extends Controller
{
    public function __invoke(Orphan $orphan)
    {
        return EidSuitResource::make($orphan->load(['eidSuit', 'family:zone_id,id,address,income_rate', 'family.zone:id,name', 'sponsor:id,first_name,last_name,phone_number']));
    }
}
