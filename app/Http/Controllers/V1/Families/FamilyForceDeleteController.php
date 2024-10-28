<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Models\Family;
use DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Throwable;

class FamilyForceDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:destroy_trash'];
    }

    /**
     * @throws Throwable
     */
    public function __invoke(Family $family)
    {
        DB::transaction(function () use ($family): void {
            $family->unSearchWithRelations();

            $family->forceDeleteWithRelationships();
        });

        return redirect()->back();
    }
}
