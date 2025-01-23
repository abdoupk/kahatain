<?php

namespace App\Http\Controllers\V1\Transcripts;

use App\Http\Controllers\Controller;
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
        $transcript->delete();

        //        dispatch(new MemberTrashedJob($transcript, auth()->user()));

        return redirect()->back();
    }
}
