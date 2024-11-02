<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadLogoController extends Controller
{
    public function __invoke(Request $request)
    {
        auth()->user()->tenant->addMediaFromRequest('filepond')->toMediaCollection('logos');
    }
}
