<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Benefactor\BenefactorTrashedJob;
use App\Models\Benefactor;
use App\Models\Family;
use App\Models\Sponsorship;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorDestroyController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:delete_benefactors'];
    }

    public function __invoke(Benefactor $benefactor)
    {
        $benefactor->sponsorships()->each(function (Sponsorship $sponsorship) {
            $recipientable = $sponsorship->recipientable()->first();

            $sponsorship->delete();

            if ($recipientable instanceof Family) {
                monthlySponsorship($recipientable);
            } else {
                monthlySponsorship($recipientable->family);
            }
        });

        $benefactor->delete();

        dispatch(new BenefactorTrashedJob($benefactor, auth()->user()));

        return redirect()->back();
    }
}
