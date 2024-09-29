<?php

namespace App\Http\Controllers\V1\Landing;

use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function __invoke()
    {
        return view('landing');
    }
}
