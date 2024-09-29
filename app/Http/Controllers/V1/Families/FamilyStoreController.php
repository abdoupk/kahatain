<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Families\CreateFamilyRequest;
use App\Jobs\V1\Family\FamilyCreatedJob;
use App\Models\Family;
use App\Models\Sponsor;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Throwable;

class FamilyStoreController extends Controller implements HasMiddleware
{
    /**
     * @throws Throwable
     */
    public function __invoke(CreateFamilyRequest $request): Response
    {
        if ($request->validated('submitted')) {
            DB::transaction(function () use ($request): void {
                $family = Family::create(
                    [
                        ...$request->only(
                            'address',
                            'zone_id',
                            'file_number',
                            'start_date',
                            'branch_id'
                        ),
                        'name' => $request->validated('sponsor.first_name')
                            . '  ' .
                            $request->validated('sponsor.last_name'),
                    ]
                );

                $sponsor = $this->storeSponsor($request, $family);

                $this->storePreview($request, $family);

                $this->storeOrphans($request, $family, $sponsor);

                if (! empty(array_filter($request->validated('second_sponsor')))) {
                    $family->secondSponsor()->create($request->validated('second_sponsor'));
                }

                $family->deceased()->create($request->validated('spouse'));

                $this->storeHousingInformations($family, $request);

                $this->storeSponsorships($family, $request, $sponsor);

                dispatch(new FamilyCreatedJob($family, auth()->user()));
            });

            return response('', 201);
        }

        return response('', 422);
    }
    public static function middleware()
    {
        return ['can:create_families'];
    }

    public function storeOrphans(CreateFamilyRequest $request, Model|Family $family, Sponsor $sponsor): void
    {
        $validatedOrphans = $request->orphans;
        $babiesToCreate = [];

        $orphans = $family->orphans()->createMany(array_map(static function ($orphan) use ($sponsor) {
            $orphan['sponsor_id'] = $sponsor->id;

            return array_filter($orphan, function ($key) {
                return ! in_array($key, [
                    'baby_milk_quantity',
                    'baby_milk_type',
                    'diapers_quantity',
                    'diapers_type',
                    'vocational_training_id',
                ]);
            }, ARRAY_FILTER_USE_KEY);
        }, $validatedOrphans));

        foreach ($validatedOrphans as $key => $orphan) {
            $orphan = array_filter($orphan);

            if (! empty($orphan) && isset(
                $orphan['baby_milk_quantity'],
                $orphan['baby_milk_type'],
                $orphan['diapers_quantity'],
                $orphan['diapers_type'])
            ) {
                $babiesToCreate[] = [
                    'baby_milk_quantity' => $orphan['baby_milk_quantity'],
                    'baby_milk_type' => $orphan['baby_milk_type'],
                    'diapers_quantity' => $orphan['diapers_quantity'],
                    'diapers_type' => $orphan['diapers_type'],
                    'orphan_id' => $orphans[$key]->id,
                ];
            }

            $orphans[$key]->sponsorships()->create([
                ...$request->validated('orphans_sponsorship')[$key],
            ]);

            if (isset($orphan['vocational_training_id'])) {
                $orphans[$key]->vocationalTrainingAchievements()->create([
                    'year' => now()->year,
                    'vocational_training_id' => $request->validated('orphans')[$key]['vocational_training_id'],
                ]);
            }
        }

        if (! empty($babiesToCreate)) {
            $family->babies()->createMany($babiesToCreate);
        }
    }

    public function storeHousingInformations(Model|Family $family, CreateFamilyRequest $request): void
    {
        $family->housing()->create([
            'name' => $request->validated('housing.housing_type.name'),
            'value' => $request->validated('housing.housing_type.value'),
            'number_of_rooms' => $request->validated('housing.number_of_rooms'),
            'housing_receipt_number' => $request->validated('housing.housing_receipt_number'),
            'other_properties' => $request->validated('other_properties'),
        ]);

        $family->furnishings()->create($request->validated('furnishings'));
    }

    public function storeSponsorships(Model|Family $family, CreateFamilyRequest $request, Sponsor $sponsor): void
    {
        $family->sponsorships()->create($request->validated('family_sponsorship'));

        $sponsor->sponsorships()->create($request->validated('sponsor_sponsorship'));
    }

    private function storeSponsor(CreateFamilyRequest $request, Model|Family $family): Sponsor
    {
        $sponsor = $family->sponsor()->create([...$request->validated('sponsor')]);

        $sponsor->incomes()->create([
            ...$request->validated('incomes'),
            'total_income' => array_sum($request->validated('incomes')),
        ]);

        return $sponsor;
    }

    private function storePreview(CreateFamilyRequest $request, Model|Family $family): void
    {
        $preview = $family->preview()->create([
            'preview_date' => $request->validated('preview_date'),
            'report' => $request->validated('report'),
        ]);

        $preview->inspectors()->sync($request->validated('inspectors_members'));
    }
}
