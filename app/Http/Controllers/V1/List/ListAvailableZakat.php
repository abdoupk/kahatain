<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\Finance;

class ListAvailableZakat extends Controller
{
    public function __invoke()
    {
        return Finance::with('familyZakats')
            ->select(['name', 'amount', 'id', 'created_at'])
            ->whereSpecification('zakat')
            ->where('amount', '>', 0)
            ->whereNotIn('id', function ($query) {
                $query->select('zakat_id')->from('family_zakats');
            })->latest('created_at')
            ->get();
    }
}
