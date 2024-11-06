<?php

namespace App\Http\Controllers\V1\SiteSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SiteSettings\UpdateSiteInfosRequest;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Storage;

class SiteSettingUpdateInfosController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_settings'];
    }

    public function __invoke(UpdateSiteInfosRequest $request): ResponseFactory|Response|Application
    {
        $data = $request->except(['super_admin', 'logo']);

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

        auth()->user()->tenant()->update([
            'data->infos' => $data,
        ]);

        if ($request->logo === null) {
            auth()->user()->tenant->clearMediaCollection('logos');
        } elseif ($request->logo && $request->logo !== auth()->user()->tenant->getFirstMediaUrl('logos')) {
            if (Storage::exists($request->logo)) {
                auth()->user()->tenant->clearMediaCollection('logos');

                auth()->user()->tenant->addMediaFromDisk($request->logo)->toMediaCollection('logos');
            }
        }

        return response('', 204);
    }
}
