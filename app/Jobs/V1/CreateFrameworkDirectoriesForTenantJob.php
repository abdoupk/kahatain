<?php

namespace App\Jobs\V1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Stancl\Tenancy\Database\Models\Tenant;

class CreateFrameworkDirectoriesForTenantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Tenant $tenant) {}

    public function handle(): void
    {
        $this->tenant->run(function (): void {
            $storage_path = storage_path();

            mkdir("{$storage_path}/framework/cache", 0777, true);
        });
    }
}
