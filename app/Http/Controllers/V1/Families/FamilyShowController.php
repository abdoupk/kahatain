<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Families\FamilyShowResource;
use App\Models\Family;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class FamilyShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_families'];
    }

    public function __invoke(Family $family): Response
    {
        $family = $family->load(
            [
                'zone',
                'orphans.academicLevel',
                'orphans.shoesSize',
                'orphans.pantsSize',
                'orphans.archives',
                'orphans.babyNeeds.babyMilk',
                'orphans.babyNeeds.diapers',
                'orphans.shirtSize',
                'babies.archives',
                'furnishings',
                'housing',
                'sponsor.incomes',
                'sponsor.creator',
                'secondSponsor',
                'furnishings',
                'branch',
                'preview.inspectors',
                'deceased.media',
                'media',
                'archives',
            ]
        );

        return Inertia::render(
            'Tenant/families/details/FamilyDetailPage',
            [
                'family' => fn () => FamilyShowResource::make($family),
                'archives' => fn () => $this->getArchives($family),
                'needs' => fn () => $this->getNeeds($family),
            ]
        );
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

        $perPageArchives = 10;
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

        $perPageNeeds = 10;
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
