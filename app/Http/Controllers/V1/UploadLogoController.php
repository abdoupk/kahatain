<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class UploadLogoController extends Controller
{
    public function __invoke(Request $request)
    {
        //        auth()->user()->tenant->addMediaFromRequest('filepond')->toMediaCollection('logos');

        $file = sha1($request->file('filepond')->getClientOriginalName()).'.'.$request->file('filepond')->getClientOriginalExtension();

        return response()->json([
            'filepath' => Storage::disk('public')->putFileAs('logos', $request->file('filepond'), $file),
        ]);
    }
}
