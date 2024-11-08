<?php

namespace App\Http\Controllers\V1\SiteSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SiteSettings\UpdateCalculationWeightsRequest;
use Illuminate\Routing\Controllers\HasMiddleware;

class UpdateCalculationWeightsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_settings'];
    }

    public function __invoke(UpdateCalculationWeightsRequest $request)
    {
        $data = json_decode(auth()->user()->tenant->calculation, true);

        $data['weights'] = array_replace($data['weights'], $request->weights);

        $data['percentage_of_contribution'] = array_replace($data['percentage_of_contribution'], $request->percentage_of_contribution);

        $data['unemployed_contribution'] = array_replace($data['unemployed_contribution'], $request->unemployed_contribution);

        $data['handicapped_contribution'] = array_replace($data['handicapped_contribution'], $request->handicapped_contribution);


        auth()->user()->tenant->update([
            'calculation' => json_encode($data),
        ]);

        return response('', 204);
    }
}
