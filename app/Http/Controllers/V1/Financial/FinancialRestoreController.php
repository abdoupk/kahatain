<?php

namespace App\Http\Controllers\V1\Financial;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Routing\Controllers\HasMiddleware;

class FinancialRestoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:restore_trash'];
    }

    public function __invoke(Finance $finance)
    {
        $finance->restore();

        return redirect()->back();
    }
}
