<?php

namespace App\Http\Controllers\V1\SiteSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SiteSettings\UpdateCalculationWeightsRequest;
use Illuminate\Routing\Controllers\HasMiddleware;

class UpdateCalculationWeightsController extends Controller implements HasMiddleware
{
    public function __invoke(UpdateCalculationWeightsRequest $request)
    {
        auth()->user()->tenant->update([
            'calculation' => json_encode($request->validated()),
        ]);

        return response('', 204);
    }

    public static function middleware()
    {
        return ['can:update_settings'];
    }
}
