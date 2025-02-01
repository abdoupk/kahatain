<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Families\FamilyShowResource;
use App\Models\Baby;
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
                'babies.orphan',
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
        $allArchives = $family->archives->merge(
            $family->orphans->flatMap(function ($orphan) {
                return $orphan->archives->map(function ($archive) use ($orphan) {
                    return $archive->forceFill([
                        'recipient_id' => $orphan->id,
                        'archiveable_type' => 'orphan',
                        'recipient_name' => $orphan->getName(),
                    ]);
                });
            })
        )->merge(
            $family->babies->flatMap(function (Baby $baby) {
                return $baby->archives->map(function ($archive) use ($baby) {
                    return $archive->forceFill([
                        'recipient_id' => $baby->orphan->id,
                        'archiveable_type' => 'orphan',
                        'recipient_name' => $baby->getName(),
                    ]);
                });
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
        $needs = $family->sponsor->needs;

        $orphanNeeds = $family->orphans()->with('needs')->get()->flatMap(function ($orphan) {
            return $orphan->needs->map(function ($archive) use ($orphan) {
                return $archive->forceFill([
                    'recipient_id' => $orphan->id,
                    'needable_type' => 'orphan',
                    'recipient_name' => $orphan->getName(),
                ]);
            });
        });

        $allNeeds = $needs->merge($orphanNeeds);

        $perPageNeeds = 10;

        $currentPageNeeds = request()->integer('needs_page', 1);

        $currentItemsNeeds = $allNeeds->slice(($currentPageNeeds - 1) * $perPageNeeds, $perPageNeeds)->all();

        ray($currentItemsNeeds);

        $paginatedNeeds = new LengthAwarePaginator($currentItemsNeeds, $allNeeds->count(), $perPageNeeds, $currentPageNeeds, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => [
                'needs_page' => request()->integer('needs_page'),
                'archives_page' => request()->integer('archives_page'),
            ],
        ]);

        $data = $paginatedNeeds->toArray();

        $data['meta'] = [
            'current_page' => $paginatedNeeds->currentPage(),
            'last_page' => $paginatedNeeds->lastPage(),
            'total' => $paginatedNeeds->total(),
            'per_page' => $paginatedNeeds->perPage(),
            'from' => $paginatedNeeds->firstItem(),
            'to' => $paginatedNeeds->lastItem(),
            'path' => $paginatedNeeds->path(),
        ];

        return $data;
    }
}
