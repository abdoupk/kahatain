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
        $orphan->load([
            'transcripts' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
            'transcripts.subjects',
        ])->loadCount('transcripts');

        if ($orphan->transcripts_count !== 3) {
            abort(404);
        }

        ray($orphan->transcripts);

        return Inertia::render('Tenant/transcripts/general-average/TranscriptGeneralAveragePage', [
            'grades' => $orphan->transcripts->map(function (Transcript $transcript) {
                return $transcript->subjects->map(function (Subject $subject) {
                    return [
                        'name' => $subject->getName(),
                        'grade' => number_format($subject->pivot->grade, 2),
                    ];
                });
            }),
            'averages' => $orphan->transcripts->map(fn ($transcript) => number_format($transcript->average, 2)),
        ]);
    }
}
