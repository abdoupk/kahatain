<?php

namespace App\Http\Controllers\V1\Students;

use App\Http\Controllers\Controller;
use DB;

class StartNewSchoolYearController extends Controller
{
    public function __invoke()
    {
        DB::table('transcripts')->truncate();

        return response('', 200);
    }
}
