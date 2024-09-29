<?php

namespace App\Http\Controllers\V1\Needs;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Needs\NeedUpdateResource;
use App\Models\Need;
use Illuminate\Routing\Controllers\HasMiddleware;

class NeedShowController extends Controller implements HasMiddleware
{
    public function __invoke(Need $need)
    {
        return response()->json([
            'need' => NeedUpdateResource::make($need),
        ]);
    }

    public static function middleware()
    {
        return ['can:view_needs'];
    }
}
