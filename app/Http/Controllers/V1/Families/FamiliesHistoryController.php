<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;

class FamiliesHistoryController extends Controller
{
    public function __invoke(Request $request, Family $family)
    {
        return Inertia::render('Tenant/families/history/HistoryIndexPage', [
            'archives' => fn () => $this->getArchives($family),
            'needs' => fn () => $this->getNeeds($family),
            'familyId' => $family->id,
        ]);
    }

    public function getArchives(Family $family)
    {
        // Combine all archives
        $allArchives = $family->archives->merge(
            $family->orphans->flatMap(function ($orphan) {
                return $orphan->archives;
            })
        )->merge(
            $family->babies->flatMap(function ($baby) {
                return $baby->archives;
            })
        );

        // Paginate the combined archives
        $perPageArchives = 1; // Number of items per page for archives
        $currentPageArchives = request()->integer('archives_page', 1);
        $currentItemsArchives = $allArchives->slice(($currentPageArchives - 1) * $perPageArchives, $perPageArchives)->all();
        $paginatedArchives = new LengthAwarePaginator($currentItemsArchives, $allArchives->count(), $perPageArchives, $currentPageArchives, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => [
                'needs_page' => request()->integer('needs_page'),
                'archives_page' => request()->integer('archives_page'),
            ],
        ]);

        $data = $paginatedArchives->toArray();

        $data['meta'] = [
            'current_page' => $paginatedArchives->currentPage(),
            'last_page' => $paginatedArchives->lastPage(),
            'total' => $paginatedArchives->total(),
            'per_page' => $paginatedArchives->perPage(),
            'from' => $paginatedArchives->firstItem(),
            'to' => $paginatedArchives->lastItem(),
            'path' => $paginatedArchives->path(),
        ];

        return $data;
    }

    public function getNeeds(Family $family)
    {

        $needs = $family->sponsorsNeeds()->paginate(1);

        $orphanNeeds = $family->orphans()->with('needs')->get()->flatMap(function ($orphan) {
            return $orphan->needs;
        });

        $allNeeds = $needs->merge($orphanNeeds);

        $perPageNeeds = 1;
        $currentPageNeeds = request()->integer('needs_page', 1);
        $currentItemsArchives = $allNeeds->slice(($currentPageNeeds - 1) * $perPageNeeds, $perPageNeeds)->all();
        $paginatedArchives = new LengthAwarePaginator($currentItemsArchives, $allNeeds->count(), $perPageNeeds, $currentPageNeeds, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => [
                'needs_page' => request()->integer('needs_page'),
                'archives_page' => request()->integer('archives_page'),
            ],
        ]);

        $data = $paginatedArchives->toArray();

        $data['meta'] = [
            'current_page' => $paginatedArchives->currentPage(),
            'last_page' => $paginatedArchives->lastPage(),
            'total' => $paginatedArchives->total(),
            'per_page' => $paginatedArchives->perPage(),
            'from' => $paginatedArchives->firstItem(),
            'to' => $paginatedArchives->lastItem(),
            'path' => $paginatedArchives->path(),
        ];

        return $data;

    }
}
