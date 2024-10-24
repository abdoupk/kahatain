<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Benefactors\BenefactorShowResource;
use App\Models\Benefactor;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorDetailsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'can:view_benefactors',
        ];
    }

    public function __invoke(Benefactor $benefactor): JsonResponse
    {
        return response()->json([
            'benefactor' => BenefactorShowResource::make($benefactor->load(['creator:id,first_name,last_name', 'sponsorships.creator', 'sponsorships.recipientable'])),
        ]);
    }
}
