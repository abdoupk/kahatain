<?php

namespace App\Http\Controllers\V1\Needs;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Needs\NeedShowResource;
use App\Models\Need;
use Illuminate\Routing\Controllers\HasMiddleware;

class NeedDetailsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_needs'];
    }

    public function __invoke(Need $need)
    {
        return response()->json([
            'need' => NeedShowResource::make(
                $need->load([
                    'needable:id,first_name,last_name',
                    'creator:id,first_name,last_name',
                ])
            ),
        ]);
    }
}
