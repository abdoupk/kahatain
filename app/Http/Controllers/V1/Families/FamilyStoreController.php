<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Families\CreateFamilyRequest;
use App\Jobs\V1\Family\FamilyCreatedJob;
use App\Models\Branch;
use App\Models\Family;
use App\Models\Sponsor;
use Arr;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class FamilyStoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:create_families'];
    }

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
                            'start_date',
                            'branch_id',
                            'location'
                        ),
                        'name' => $request->validated('sponsor.first_name')
                            .'  '.
                            $request->validated('sponsor.last_name'),
                        'file_number' => Branch::with('city')->find($request->validated('branch_id'))->city->commune_code.'/'.Family::count() + 1,
                    ]
                );

                addToMediaCollection($family, $request->validated('residence_file'), 'residence_files');

                $sponsor = $this->storeSponsor($request, $family);

                $this->storePreview($request, $family);

                $this->storeOrphans($request, $family, $sponsor);

                if (! empty(array_filter($request->validated('second_sponsor')))) {
                    $family->secondSponsor()->create($request->validated('second_sponsor'));
                }

                $family->deceased()->createMany(Arr::except($request->validated('spouse'), ['death_certificate_file']));

                addToMediaCollection($family->deceased, $request->validated('spouse.death_certificate_file'), 'death_certificate_files');

                $this->storeHousingInformations($family, $request);

                monthlySponsorship($family);

                dispatch(new FamilyCreatedJob($family, auth()->user()));
            });

            return response('', 201);
        }

        return response('', 422);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    private function storeSponsor(CreateFamilyRequest $request, Model|Family $family): Sponsor
    {
        $sponsor = $family->sponsor()->create(Arr::except($request->validated('sponsor'), ['photo', 'diploma_file', 'no_remarriage_file', 'birth_certificate_file']));

        $income = $sponsor->incomes()->create([
            ...$request->only(
                ['incomes.casnos', 'incomes.ccp', 'incomes.account', 'incomes.cnr',
                    'incomes.cnas', 'incomes.other_income', 'incomes.pension']
            )['incomes'],
            'total_income' => setTotalIncomeAttribute($request->incomes, $sponsor),
        ]);

        addToMediaCollection($sponsor, $request->validated('sponsor.diploma_file'), 'diploma_files');

        addToMediaCollection($sponsor, $request->validated('sponsor.birth_certificate_file'), 'birth_certificate_files');

        addToMediaCollection($sponsor, $request->validated('sponsor.photo'), 'photos');

        addToMediaCollection($income, $request->validated('incomes.bank_file'), 'bank_files');

        addToMediaCollection($income, $request->validated('incomes.ccp_file'), 'ccp_files');

        addToMediaCollection($income, $request->validated('incomes.casnos_file'), 'casnos_files');

        addToMediaCollection($income, $request->validated('incomes.cnas_file'), 'cnas_files');

        addToMediaCollection($income, $request->validated('incomes.cnr_file'), 'cnr_files');

        addToMediaCollection($sponsor, $request->validated('sponsor.no_remarriage_file'), 'no_remarriage_files');

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

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function storeOrphans(CreateFamilyRequest $request, Model|Family $family, Sponsor $sponsor): void
    {
        $target = $request->validated('orphans');
        $validatedOrphans = data_forget($target, 'orphans.*.vocational_training_id');
        $babiesToCreate = [];

        $orphans = $family->orphans()->createMany(array_map(static function ($orphan) use ($sponsor) {
            $orphan['sponsor_id'] = $sponsor->id;

            unset($orphan['photo']);

            return array_filter($orphan, function ($key) {
                return ! in_array($key, [
                    'baby_milk_quantity',
                    'baby_milk_type',
                    'diapers_quantity',
                    'diapers_type',
                ]);
            }, ARRAY_FILTER_USE_KEY);
        }, $validatedOrphans));

        foreach ($validatedOrphans as $key => $orphan) {
            $orphan = array_filter($orphan);

            if (isset($orphan['photo'])) {
                addToMediaCollection($orphans[$key], $orphan['photo'], 'photos');
            }

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

        $family->furnishings()->create([
            ...$request->validated('furnishings'),
        ]);
    }
}
