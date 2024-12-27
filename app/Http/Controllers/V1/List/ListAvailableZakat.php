<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\Finance;

class ListAvailableZakat extends Controller
{
    public function __invoke()
    {
        return Finance::with(['receiver:id,first_name,last_name'])
            ->whereSpecification('zakat')
            ->where('amount', '>', 0)
            ->get()->map(function (Finance $finance) {
                return [
                    'id' => $finance->id,
                    'amount' => $finance->amount,
                    'name' => formatCurrency($finance->amount)
                        .' ('
                        .$finance->date->translatedFormat('j')
                        .__('glue')
                        .$finance->date->translatedFormat('F Y')
                        .' - '
                        .$finance->receiver->getName()
                        .')',
                ];
            });
    }
}
