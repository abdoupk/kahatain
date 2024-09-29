<?php

namespace App\Http\Controllers\V1\SiteSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SiteSettings\UpdateSiteInfosRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;

class SiteSettingUpdateInfosController extends Controller implements HasMiddleware
{
    public function __invoke(UpdateSiteInfosRequest $request): void
    {
        $data = $request->except('super_admin');

        $superAdmin = User::whereId($request->super_admin)->first();

        $superAdmin->syncRoles('super_admin');

        $data['super_admin'] = [
            'id' => $superAdmin->id,
            'first_name' => $superAdmin->first_name,
            'last_name' => $superAdmin->last_name,
            'name' => $superAdmin->getName(),
            'email' => $superAdmin->email,
            'password' => $superAdmin->password,
        ];

        Tenant::whereId(tenant('id'))->update([
            'data->infos' => $data,
        ]);
    }

    public static function middleware()
    {
        return ['can:update_settings'];
    }
}
