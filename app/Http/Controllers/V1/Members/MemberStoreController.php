<?php

namespace App\Http\Controllers\V1\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Members\MemberCreateRequest;
use App\Jobs\V1\Member\MemberCreatedJob;
use App\Models\Committee;
use App\Models\competence;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class MemberStoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:create_members'];
    }

    public function __invoke(MemberCreateRequest $request): Response
    {
        $user = User::create(
            [
                ...$request->only(
                    [
                        'password', 'email', 'last_name', 'first_name', 'phone',
                        'zone_id', 'branch_id', 'qualification', 'gender', 'address', 'workplace', 'function', 'location', 'academic_level_id',
                    ]
                ),
                'created_by' => auth()->id(),
            ],
        );

        //        if ($request->roles) {
        //            $user->syncRoles($request->roles);
        //        }

        $this->syncCompetences($request->competences, $user);

        $this->syncCommittees($request->committees, $user);

        $user->searchable();

        //        $user->roles()->searchable();

        dispatch(new MemberCreatedJob($user, auth()->user()));

        return response('', 201);
    }

    private function syncCompetences(array $competenceNames, User $user)
    {
        $allCompetenceIds = collect($competenceNames)->map(fn ($competenceName) => competence::firstOrCreate(['name' => $competenceName['name']]))->pluck('id')->toArray();

        $user->competences()->sync($allCompetenceIds);
    }

    private function syncCommittees(mixed $committeeNames, User $user)
    {
        $allCommitteeIds = collect($committeeNames)->map(fn ($committeeName) => Committee::firstOrCreate(['name' => $committeeName['name']]))->pluck('id')->toArray();

        $user->competences()->sync($allCommitteeIds);
    }
}
