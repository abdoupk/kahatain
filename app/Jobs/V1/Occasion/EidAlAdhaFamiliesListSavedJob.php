<?php

namespace App\Jobs\V1\Occasion;

use App\Models\Archive;
use App\Models\FamilyEidAlAdha;
use App\Models\User;
use App\Notifications\Occasion\SaveEidAlAdhaFamiliesListNotification;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;
use Throwable;

class EidAlAdhaFamiliesListSavedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Archive $archive, public User $user) {}

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        DB::transaction(function () {
            FamilyEidAlAdha::where('year', $this->archive->updated_at->year)->delete();

            $data = $this->archive->families->map(function ($family) {
                return [
                    'family_id' => $family->id,
                    'year' => $this->archive->updated_at->year,
                    'status' => $family->eid_al_adha_status,
                    'updated_by' => $this->user->id,
                    'tenant_id' => $this->user->tenant_id,
                ];
            })->toArray();

            FamilyEidAlAdha::insert($data);
        });

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['view_occasions'],
                userToExclude: $this->user,
                notificationType: 'occasions_saves'
            ),
            new SaveEidAlAdhaFamiliesListNotification(
                archive: $this->archive,
                user: $this->user
            )
        );
    }
}
