<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolTool extends Model
{
    protected $fillable = [
        'name',
        'min_price',
        'max_price',
    ];
}
