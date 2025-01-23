<?php

namespace App\Console\Commands;

use App\Models\Family;
use Illuminate\Console\Command;
use Log;

class CalculateFamiliesIncomeRateCommand extends Command
{
    protected $signature = 'calculate:families-income-rate';

    protected $description = 'Calculate families income rate';

    public function handle(): void
    {
        Log::error('454545');
        ray('5656565656');
        Family::each(fn (Family $family) => monthlySponsorship($family));
    }
}
