<?php

namespace App\Http\Controllers\V1\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Settings\UpdateSettingsRequest;
use Illuminate\Routing\Controllers\HasMiddleware;

class UpdateSettingsController extends Controller implements HasMiddleware
{
    public function __invoke(UpdateSettingsRequest $request)
    {
        auth()->user()->settings->update($request->validated());

        return response('', 204);
    }

    public static function middleware()
    {
        return ['can:update_settings'];
    }
}
