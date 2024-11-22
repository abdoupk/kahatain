<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Models\AcademicLevel;
use App\Models\Orphan;
use App\Models\Subject;
use Illuminate\Http\Request;

class TranscriptSubjectsController extends Controller
{
    public function __invoke(Request $request, Orphan $orphan)
    {
        return response()->json([
            'subjects' => Subject::whereIn('id', AcademicLevel::whereId($orphan->academic_level_id)->first()?->subject_ids)->get()->map(fn (Subject $subject) => [
                'id' => $subject->id,
                'name' => $subject->getName(),
            ]),
        ]);
    }
}
