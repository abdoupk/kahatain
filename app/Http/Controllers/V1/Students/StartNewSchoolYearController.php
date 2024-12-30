<?php

namespace App\Http\Controllers\V1\Students;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Routing\Controllers\HasMiddleware;

class StartNewSchoolYearController extends Controller implements HasMiddleware
{
    public function __invoke()
    {
        DB::table('transcripts')->truncate();

        return response('', 200);
    }

    public static function middleware()
    {
        return ['can:start_new_academic_year'];
    }
}
