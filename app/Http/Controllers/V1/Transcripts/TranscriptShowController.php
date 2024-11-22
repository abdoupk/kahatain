<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TranscriptShowController extends Controller
{
    public function __invoke(Request $request)
    {
        ray($request->all());
    }
}
