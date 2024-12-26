<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Transcripts\GeneralAverageUpdateRequest;
use App\Models\Orphan;

class TranscriptUpdateGeneralAverageController extends Controller
{
    public function __invoke(GeneralAverageUpdateRequest $request, Orphan $orphan)
    {
        $orphan->update([
            'academic_average' => $request->general_average,
        ]);

        $orphan->searchable();
    }
}
