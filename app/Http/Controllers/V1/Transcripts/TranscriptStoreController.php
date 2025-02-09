<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Transcripts\TranscriptCreateUpdateRequest;
use App\Jobs\V1\Transcript\TranscriptCreatedJob;
use App\Models\Orphan;
use App\Models\Transcript;

class TranscriptStoreController extends Controller
{
    public function __invoke(TranscriptCreateUpdateRequest $request, Orphan $orphan)
    {
        $transcript = Transcript::create([
            'average' => $request->average,
            'trimester' => $request->trimester,
            'orphan_id' => $orphan->id,
            'academic_level_id' => $orphan->academic_level_id,
        ]);

        $transcript->subjects()->sync(
            collect($request->subjects)->mapWithKeys(fn ($subject) => [$subject['id'] => ['grade' => $subject['grade'] ?? 0]])->toArray()
        );

        $orphan = $transcript->orphan();

        if ($transcript->trimester === 'third_trimester') {
            $orphan->update([
                'academic_average' => $orphan->with('transcripts')->first()->transcripts->avg('average'),
            ]);
        }

        $orphan->searchable();

        dispatch(new TranscriptCreatedJob($orphan->with('academicLevel')->first(), $request->validated('trimester'), auth()->user()));
    }
}
