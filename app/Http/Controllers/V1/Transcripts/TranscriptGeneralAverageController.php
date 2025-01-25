<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Models\Orphan;
use Inertia\Inertia;

class TranscriptGeneralAverageController extends Controller
{
    public function __invoke(Orphan $orphan)
    {
        $transcripts = $orphan->load('transcripts.subjects')->transcripts;

        return Inertia::render('Tenant/transcripts/general-average/TranscriptGeneralAveragePage', [
            'data' => $transcripts,
        ]);
    }
}
