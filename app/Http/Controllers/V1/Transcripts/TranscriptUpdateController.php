<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Transcripts\TranscriptCreateUpdateRequest;
use App\Jobs\V1\Transcript\TranscriptUpdatedJob;
use App\Models\Transcript;

class TranscriptUpdateController extends Controller
{
    public function __invoke(TranscriptCreateUpdateRequest $request, Transcript $transcript)
    {
        $transcript->update([
            'average' => $request->average,
        ]);

        $transcript->subjects()->sync(
            collect($request->subjects)->mapWithKeys(fn ($subject) => [$subject['id'] => ['grade' => $subject['grade'] ?? 0]])->toArray()
        );

        $orphan = $transcript->orphan()->first();

        $orphan->loadCount('transcripts');

        if ($orphan->transcripts_count === 3) {
            $orphan->update([
                'academic_average' => $orphan->transcripts->avg('average'),
            ]);
        }

        $orphan->searchable();

        dispatch(new TranscriptUpdatedJob($orphan->with('academicLevel')->first(), $request->validated('trimester'), auth()->user()));
    }
}
