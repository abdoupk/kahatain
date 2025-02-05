<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    public function getName(): string
    {
        return $this[app()->getLocale().'_name'];
    }

    public function transcripts(): BelongsToMany
    {
        return $this->belongsToMany(Transcript::class)->using(SubjectTranscript::class);
    }
}
