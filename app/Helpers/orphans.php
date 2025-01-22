<?php

/** @noinspection UnknownInspectionInspection */

use App\Models\AcademicLevel;
use App\Models\Orphan;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

function getOrphans(): LengthAwarePaginator
{
    return search(Orphan::getModel())
        ->query(fn ($query) => $query->with(['academicLevel', 'family:id,income_rate', 'pantsSize', 'shoesSize', 'shirtSize', 'babyNeeds.babyMilk', 'babyNeeds.diapers']))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function searchOrphans(): Collection
{
    return search(Orphan::getModel(), limit: LIMIT)->get();
}

function getOrphansForExport(): Collection
{
    return search(Orphan::getModel(), limit: 10000)
        ->query(fn ($query) => $query->with(
            ['academicLevel',
                'pantsSize',
                'shoesSize',
                'shirtSize',
            ]
        ))
        ->get();
}

function validateClothesAttributes($birthDate, $academicLevelId, $familyStatus, $value): bool
{
    // Condition 1: Family status is 'college_girl' or 'college_boy'
    if (in_array($familyStatus, ['college_girl', 'college_boy'], true) && $value === null) {
        return true;
    }

    // Condition 2: Age is between 2 and 6
    if ($birthDate) {
        $age = Carbon::parse($birthDate)->age;

        if ($age > 2 && $age <= 6 && $value === null) {
            return true;
        }
    }

    // Condition 3: Academic level is primary, middle, or high school
    if ($academicLevelId) {
        $phaseKey = AcademicLevel::find($academicLevelId)?->phase_key;
        ray($phaseKey);

        if (in_array($phaseKey, ['primary_education', 'middle_education', 'secondary_education'], true) && $value === null) {
            return true;
        }
    }

    return false;
}
