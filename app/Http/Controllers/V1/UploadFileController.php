<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

class UploadFileController extends Controller
{
    public function __invoke(Request $request)
    {
        return $request->file('filepond')->store('tmp/'.now()->timestamp.'-'.Str::random(20));
    }
}
