<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class CompetenceUser extends Pivot
{
    use BelongsToTenant, HasUuids;

    public $timestamps = false;
}
