<?php

namespace App\Http\Controllers\V1\Occasions;

use App\Http\Controllers\Controller;
use Inertia\Response;

class OccasionsStatisticsIndexController extends Controller
{
    public function __invoke(): Response
    {
        return inertia()->render('Tenant/occasions/statistics/index/StatisticsIndexPage');
    }
}
