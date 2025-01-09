<?php

namespace App\Http\Controllers\V1\Occasions\EidSuit;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Occasions\EidSuit\BulkUpdateEidSuitInfosRequest;

class BulkUpdateEidSuitInfosController extends Controller
{
    public function __invoke(BulkUpdateEidSuitInfosRequest $request)
    {
        ray($request->all());
    }
}
