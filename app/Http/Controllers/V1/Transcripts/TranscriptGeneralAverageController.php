<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Models\Orphan;
use App\Models\Subject;
use App\Models\Transcript;
use Inertia\Inertia;

class TranscriptGeneralAverageController extends Controller
{
    public function __invoke(Orphan $orphan)
    {
        $orphan->load('transcripts.subjects')->loadCount('transcripts');

        if ($orphan->transcripts_count !== 3) {
            abort(404);
        }

        return Inertia::render('Tenant/transcripts/general-average/TranscriptGeneralAveragePage', [
            'data' => $orphan->transcripts->map(function (Transcript $transcript) {
                return $transcript->subjects->map(function (Subject $subject) use ($transcript) {
                    return [
                        'name' => $subject->getName(),
                        'grade' => $subject->pivot->grade,
                        'trimester' => $transcript->trimester,
                    ];
                });
            }),
        ]);
    }
}
