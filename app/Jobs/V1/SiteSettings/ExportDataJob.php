<?php

namespace App\Jobs\V1\SiteSettings;

use App\Exports\FullExports\BabiesExport;
use App\Exports\FullExports\BabiesMilkAndDiapersListExport;
use App\Exports\FullExports\BranchesExport;
use App\Exports\FullExports\EidAlAdhaFamiliesListExport;
use App\Exports\FullExports\EidSuitOrphansListExport;
use App\Exports\FullExports\FamiliesExport;
use App\Exports\FullExports\FinanceTransactionsExport;
use App\Exports\FullExports\InventoryExport;
use App\Exports\FullExports\LessonsExport;
use App\Exports\FullExports\MonthlyBasketFamiliesExport;
use App\Exports\FullExports\NeedsExport;
use App\Exports\FullExports\OrphansExport;
use App\Exports\FullExports\RamadanBasketFamiliesListExport;
use App\Exports\FullExports\SchoolEntryOrphansListExport;
use App\Exports\FullExports\SchoolsExport;
use App\Exports\FullExports\SponsorsExport;
use App\Exports\FullExports\UsersExport;
use App\Exports\FullExports\ZonesExport;
use App\Models\Archive;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\SiteSettings\ExportCompleteNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Notification;
use Storage;
use ZipArchive;

class ExportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $path, public string $tenant)
    {
    }

    public function handle(): void
    {
        $zip = new ZipArchive();

        $zip->open($this->path, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $this->exportToExcel($zip);

        $this->addYearsDirsToArchive($zip);

        $this->exportBabiesMilkAndDiapers($zip);

        $this->exportMonthlyBasketFamiliesList($zip);

        $this->exportSchoolEntryOrphansList($zip);

        $this->exportEidSuitOrphansList($zip);

        $this->exportEidAlAdhaFamiliesList($zip);

        $this->exportRamadanBasketFamiliesList($zip);

        $zip->close();

        $this->cleanup();

        $tenant = Tenant::whereId($this->tenant)->first();

        $superAdmin = User::find($tenant->infos['super_admin']['id'])->first();

        Notification::send(
            $superAdmin,
            new ExportCompleteNotification(
                tenant: $tenant
            )
        );
    }

    private function exportToExcel(ZipArchive $zip): void
    {
        $files = [
            __('the_members') . '.xlsx' => new UsersExport(),
            __('the_zones') . '.xlsx' => new ZonesExport(),
            __('the_branches') . '.xlsx' => new BranchesExport(),
            __('the_orphans') . '.xlsx' => new OrphansExport(),
            __('the_sponsors') . '.xlsx' => new SponsorsExport(),
            __('the_families') . '.xlsx' => new FamiliesExport(),
            __('the_schools') . '.xlsx' => new SchoolsExport(),
            __('the_lessons') . '.xlsx' => new LessonsExport(),
            __('the_needs') . '.xlsx' => new NeedsExport(),
            __('search.babies') . '.xlsx' => new BabiesExport(),
            __('the_inventory') . '.xlsx' => new InventoryExport(),
            __('exports.transactions') . '.xlsx' => new FinanceTransactionsExport(),
        ];

        foreach ($files as $fileName => $export) {
            Excel::store($export, $fileName);

            $zip->addFile(Storage::path($fileName), $fileName);
        }
    }

    private function addYearsDirsToArchive(ZipArchive $zip): void
    {
        $years = Archive::whereOccasion('monthly_basket')
            ->orWhere('occasion', '=', 'babies_milk_and_diapers')
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->get()->pluck('year')->toArray();

        foreach ($years as $year) {
            $zip->addEmptyDir($year);
        }
    }

    private function exportBabiesMilkAndDiapers(ZipArchive $zip): void
    {
        $years = Archive::whereOccasion('babies_milk_and_diapers')
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->get()->pluck('year')->toArray();

        foreach ($years as $year) {
            $fileName = "{$year}/" . __('exports.babies_milk_and_diapers') . '.xlsx';

            Excel::store(new BabiesMilkAndDiapersListExport($year), $fileName);

            $zip->addFile(Storage::path($fileName), $fileName);
        }
    }

    private function exportMonthlyBasketFamiliesList(ZipArchive $zip): void
    {
        $years = Archive::whereOccasion('monthly_basket')
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->get()->pluck('year')->toArray();

        foreach ($years as $year) {
            $fileName = "{$year}/" . __('the_families_monthly_basket') . '.xlsx';

            Excel::store(new MonthlyBasketFamiliesExport($year), $fileName);

            $zip->addFile(Storage::path($fileName), $fileName);
        }
    }

    private function exportSchoolEntryOrphansList(ZipArchive $zip): void
    {
        $years = Archive::whereOccasion('school_entry')
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->get()->pluck('year')->toArray();

        $fileName = __('the_orphans_school_entry') . '.xlsx';

        Excel::store(new SchoolEntryOrphansListExport($years), $fileName);

        $zip->addFile(Storage::path($fileName), $fileName);
    }

    private function exportEidSuitOrphansList(ZipArchive $zip): void
    {
        $years = Archive::whereOccasion('eid_suit')
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->get()->pluck('year')->toArray();

        $fileName = __('the_orphans_eid_suit') . '.xlsx';

        Excel::store(new EidSuitOrphansListExport($years), $fileName);

        $zip->addFile(Storage::path($fileName), $fileName);
    }

    private function exportEidAlAdhaFamiliesList(ZipArchive $zip): void
    {
        $years = Archive::whereOccasion('eid_al_adha')
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->get()->pluck('year')->toArray();

        $fileName = __('the_families_eid_al_adha') . '.xlsx';

        Excel::store(new EidAlAdhaFamiliesListExport($years), $fileName);

        $zip->addFile(Storage::path($fileName), $fileName);
    }

    private function exportRamadanBasketFamiliesList(ZipArchive $zip): void
    {
        $years = Archive::whereOccasion('ramadan_basket')
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->get()->pluck('year')->toArray();

        $fileName = __('the_families_ramadan_basket') . '.xlsx';

        Excel::store(new RamadanBasketFamiliesListExport($years), $fileName);

        $zip->addFile(Storage::path($fileName), $fileName);
    }

    private function cleanup(): void
    {
        // TODO cleanup folders and files except exported_data.zip
    }
}
