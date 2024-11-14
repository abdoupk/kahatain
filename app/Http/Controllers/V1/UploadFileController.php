<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UploadFileRequest;
use Str;

class UploadFileController extends Controller
{
    public function __invoke(UploadFileRequest $request)
    {
        return tenant_asset($request->file('filepond')->store('tmp/'.now()->timestamp.'-'.Str::random(20), ['disk' => 'public']));
    }
}
