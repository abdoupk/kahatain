<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;

final class DeleteTempUploadedFiles extends Command
{
    protected $signature = 'app:delete-temp-uploaded-files';

    protected $description = 'Delete temporary uploaded files older than 24 hours.';

    public function handle(): void
    {
        Tenant::select('id')->each(function (Tenant $tenant) {
            tenancy()->initialize($tenant);

            $tempPath = storage_path().'/app/tmp';

            $files = glob($tempPath.'/**/*.*');

            foreach ($files as $file) {
                if (is_file($file)) {
                    $creationDate = date('Y-m-d H:i:s', filectime($file));

                    if (time() - strtotime($creationDate) > 86400) {
                        unlink($file);
                    }
                }
            }
        });
    }
}
