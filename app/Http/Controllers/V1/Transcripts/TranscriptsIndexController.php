<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Transcripts\OrphansIndexResource;
use Inertia\Inertia;
use Inertia\Response;

class TranscriptsIndexController extends Controller
{
    public function __invoke(): Response
    {
        ray(OrphansIndexResource::collection(getOrphansForTranscripts()));

        return Inertia::render('Tenant/transcripts/index/OrphansIndexPage', [
            'orphans' => OrphansIndexResource::collection(getOrphansForTranscripts()),
            'params' => getParams(),
        ]);
    }
}
