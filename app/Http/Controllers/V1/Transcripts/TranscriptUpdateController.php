<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Transcripts\TranscriptCreateUpdateRequest;
use App\Models\Transcript;

class TranscriptUpdateController extends Controller
{
    public function __invoke(TranscriptCreateUpdateRequest $request, Transcript $transcript)
    {
        $transcript->update([
            'average' => $request->average,
        ]);

        $transcript->subjects()->sync(
            collect($request->subjects)->mapWithKeys(function ($subject) {
                return [$subject['id'] => ['grade' => $subject['grade'] ?? 0]];
            })->toArray()
        );
    }
}