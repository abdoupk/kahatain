<?php

namespace App\Jobs\V1;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateTenantAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Tenant $tenant) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->tenant->run(function (Tenant $tenant): void {
            setPermissionsTeamId($tenant->id);

            User::withoutSyncingToSearch(function () use ($tenant): void {
                $user = User::create($tenant->infos['super_admin']);

                $user->assignRole(Role::create(['name' => 'super_admin', 'tenant_id' => $tenant->id]));

                $tenant->update([
                    'infos' => array_merge($tenant->infos, [
                        'super_admin' => array_merge($tenant->infos['super_admin'], ['id' => $user->id]),
                    ]),
                ]);
            });
        });
    }
}
