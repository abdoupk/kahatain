<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
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
}