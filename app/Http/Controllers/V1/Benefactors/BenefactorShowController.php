<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Benefactors\BenefactorUpdateResource;
use App\Models\Benefactor;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'can:update_benefactors',
        ];
    }

    public function __invoke(Benefactor $benefactor): JsonResponse
    {
        return response()->json([
            'benefactor' => BenefactorUpdateResource::make($benefactor->load(['sponsorships.creator', 'sponsorships.recipientable'])),
        ]);
    }
}
