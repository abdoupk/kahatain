<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Models\Family;
use DB;
use Illuminate\Routing\Controllers\HasMiddleware;

class FamilyRestoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:restore_trash'];
    }

    public function __invoke(Family $family)
    {
        $family->restore();

        $family->searchable();

        $this->restore($family);

        $this->makeSearchable($family);

        return redirect()->back();
    }

    private function restore(Family $family): void
    {
        $sponsor = $family->sponsor()->withTrashed()->first();

        $orphans = $family->orphans()->withTrashed();

        $orphans->restore();

        $sponsor->restore();

        $family->babies()->withTrashed()->restore();

        DB::table('needs')->where('needable_id', $sponsor->id)
            ->orWhereIn('needable_id', $orphans->pluck('id'))
            ->update(['deleted_at' => null, 'deleted_by' => null]);
    }

    private function makeSearchable(Family $family): void
    {
        $family->sponsorships->searchable();

        $family->orphansSponsorships->searchable();

        $family->sponsorSponsorships->searchable();

        $family->orphansNeeds()->searchable();

        $family->sponsorsNeeds()->searchable();

        $family->sponsor()->searchable();

        $family->orphans->searchable();

        $family->babies->searchable();
    }
}
