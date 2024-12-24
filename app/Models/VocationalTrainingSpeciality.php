<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class VocationalTrainingSpeciality extends Model
{
    use Searchable;

    public $timestamps = false;

    protected $fillable = [
        'speciality',
        'division',
    ];

    public function orphans(): MorphMany
    {
        return $this->morphMany(Orphan::class, 'speciality');
    }
}
