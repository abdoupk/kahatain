<?php

namespace App\Http\Controllers\V1\Archive;

use App\Http\Controllers\Controller;

class ArchiveDetailsZakatController extends Controller
{
    public function __invoke()
    {
        return inertia('Tenant/archive/details/zakat/ZakatPage');
    }
}
