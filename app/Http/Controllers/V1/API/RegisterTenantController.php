<?php

namespace App\Http\Controllers\V1\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RegisterTenantRequest;
use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;

class RegisterTenantController extends Controller
{
    public function __invoke(RegisterTenantRequest $request): JsonResponse
    {
        $tenant = Tenant::create($request->validated());

        Domain::create([
            'domain' => $request->domain,
            'tenant_id' => $tenant->id,
        ]);

        return response()->json(['message' => 'registered successfully']);
    }
}
