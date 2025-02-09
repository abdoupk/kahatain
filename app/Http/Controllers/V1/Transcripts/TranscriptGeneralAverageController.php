<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Models\Orphan;
use App\Models\Subject;
use App\Models\Transcript;
use Inertia\Inertia;
use Inertia\Response;

class TranscriptGeneralAverageController extends Controller
{
    public function __invoke(Orphan $orphan): Response
    {
        $orphan->load([
            'transcripts' => function ($query): void {
                $query->orderBy('created_at', 'asc');
            },
            'transcripts.subjects',
        ])->loadCount('transcripts');

        if ($orphan->transcripts_count !== 3) {
            abort(404);
        }

        return Inertia::render('Tenant/transcripts/general-average/TranscriptGeneralAveragePage', [
            'grades' => $orphan->transcripts->map(fn (Transcript $transcript) => $transcript->subjects->map(fn (Subject $subject) => [
                'name' => $subject->getName(),
                'grade' => number_format($subject->pivot->grade, 2),
            ])),
            'averages' => $orphan->transcripts->map(fn ($transcript) => number_format($transcript->average, 2)),
        ]);
    }
}
