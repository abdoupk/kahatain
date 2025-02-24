<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RegisterTenantRequest;
use App\Models\City;
use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredTenantController extends Controller
{
    public function store(RegisterTenantRequest $request): JsonResponse
    {
        $city = City::find($request->city_id);

        $tenant = Tenant::create([
            'infos' => [
                'super_admin' => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'password' => $request->password,
                    'email' => $request->email,
                ],
                'domain' => $request->domain,
                'association' => $request->association,
                'city_id' => $request->city_id,
                'city' => [
                    'id' => $request->city_id,
                    'daira_name' => $city->daira_name,
                    'wilaya_code' => $city->wilaya_code,
                    'wilaya_name' => $city->wilaya_name,
                ],
            ],
        ]);

        Domain::create([
            'domain' => $request->domain,
            'tenant_id' => $tenant->id,
        ]);

        /** @var Domain $domain */
        $domain = $tenant->domains->first();

        return response()->json(['url' => tenant_route($domain->domain, 'tenant.dashboard')]);
    }

    public function create(): Response
    {
        return Inertia::render('Auth/Register/V2/TheRegisterPage');
    }
}
