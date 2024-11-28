<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class VocationalTrainingCenter extends Model
{
    use HasUuids;

    protected $fillable = [
        'latin_name',
        'arabic_name',
        'code',
        'wilaya_code',
        'e_id',
    ];
}
