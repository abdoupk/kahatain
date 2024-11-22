<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Transcripts\TranscriptUpdateResource;
use App\Models\Transcript;

class TranscriptShowController extends Controller
{
    public function __invoke(Transcript $transcript)
    {
        ray(TranscriptUpdateResource::make($transcript->load(['subjects', 'academicLevel'])));

        return response()->json([
            'transcript' => TranscriptUpdateResource::make($transcript->load(['subjects', 'academicLevel'])),
        ]);
    }
}
