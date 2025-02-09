<?php

namespace App\Http\Controllers\V1\Students;

use App\Http\Controllers\Controller;
use App\Jobs\V1\School\StartNewSchoolYearJob;
use DB;
use Illuminate\Routing\Controllers\HasMiddleware;

class StartNewSchoolYearController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:start_new_academic_year'];
    }

    public function __invoke()
    {
        DB::table('transcripts')->truncate();

        dispatch(new StartNewSchoolYearJob(auth()->user()));

        return response('', 200);
    }
}
