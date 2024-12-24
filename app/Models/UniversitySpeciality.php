<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class UniversitySpeciality extends Model
{
    use Searchable;

    public function orphans(): MorphMany
    {
        return $this->morphMany(Orphan::class, 'speciality');
    }
}
