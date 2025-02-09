<?php

namespace App\Http\Controllers\V1\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Settings\UpdateSettingsRequest;

class UpdateSettingsController extends Controller
{
    public function __invoke(UpdateSettingsRequest $request)
    {
        auth()->user()->settings->update($request->validated());

        return response('', 204);
    }
}
