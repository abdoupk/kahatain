<?php

namespace App\Http\Controllers\V1\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Settings\UpdateNotificationsRequest;

class UpdateNotificationsSettingsController extends Controller
{
    public function __invoke(UpdateNotificationsRequest $request)
    {
        auth()->user()->settings->update([
            'notifications' => $request->validated(),
        ]);

        return response('', 204);
    }
}
