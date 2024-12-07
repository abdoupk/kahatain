<?php

namespace App\Console\Commands;

use App\Models\Sponsorship;
use Illuminate\Console\Command;

class CleanCompletedBenefactorSponsorshipsCommand extends Command
{
    protected $signature = 'clean:completed-benefactor-sponsorships';

    protected $description = 'Command description';

    public function handle(): void
    {
        Sponsorship::with('recipientable')
            ->where('until', '<=', now())
            ->each((function (Sponsorship $sponsorship) {
                $sponsorship->delete();

                if ($sponsorship->recipientable_type === 'family') {
                    monthlySponsorship($sponsorship->recipientable);
                } elseif ($sponsorship->recipientable_type === 'orphan') {
                    monthlySponsorship($sponsorship->recipientable->load('family')->family);
                }
            }));
    }
}
