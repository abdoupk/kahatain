<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class VocationalTrainingCenter extends Model
{
    use HasUuids, Searchable;

    protected $fillable = [
        'latin_name',
        'arabic_name',
        'code',
        'wilaya_code',
        'e_id',
    ];

    public function orphans(): MorphMany
    {
        return $this->morphMany(Orphan::class, 'institution');
    }

    public function getName(): string
    {
        return app()->getLocale() === 'ar' ? $this->arabic_name : $this->latin_name;
    }
}
