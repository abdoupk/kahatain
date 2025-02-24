<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicLevelSchoolTool extends Model
{
    use HasUuids;

    protected $fillable = [
        'qty',
        'min_price',
        'max_price',
        'academic_level_id',
        'school_tool_id',
    ];

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    public function schoolTool(): BelongsTo
    {
        return $this->belongsTo(SchoolTool::class);
    }
}
