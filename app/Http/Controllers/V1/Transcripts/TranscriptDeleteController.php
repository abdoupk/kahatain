<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Transcript\TranscriptTrashedJob;
use App\Models\Transcript;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class TranscriptDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:delete_transcripts'];
    }

    public function __invoke(Transcript $transcript): RedirectResponse
    {
        $orphan = $transcript->orphan();

        $orphan->update([
            'academic_average' => null,
        ]);

        $orphan->searchable();

        dispatch(new TranscriptTrashedJob($orphan->first(), $transcript->trimester, auth()->user()));

        $transcript->delete();

        return redirect()->back();
    }
}
