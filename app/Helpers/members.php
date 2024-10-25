<?php

/** @noinspection UnknownInspectionInspection */

use App\Models\Committee;
use App\Models\competence;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/** @noinspection NullPointerExceptionInspection */
function getMembers(): LengthAwarePaginator
{
    return search(User::getModel())
        ->query(fn ($query) => $query->with('zone'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function searchMembers(): Collection
{
    return search(User::getModel(), limit: 100)->get();
}


function syncCompetences(array $competenceNames, User $user): void
{
    $allCompetenceIds = collect($competenceNames)->map(fn ($competenceName) => competence::firstOrCreate(['name' => $competenceName['name']]))->pluck('id')->toArray();

    $user->competences()->sync($allCompetenceIds);
}

function syncCommittees(mixed $committeeNames, User $user): void
{
    $allCommitteeIds = collect($committeeNames)->map(fn ($committeeName) => Committee::firstOrCreate(['name' => $committeeName['name']]))->pluck('id')->toArray();

    $user->committees()->sync($allCommitteeIds);
}
