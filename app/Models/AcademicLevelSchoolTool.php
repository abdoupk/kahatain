<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property int $qty
 * @property string $academic_level_id
 * @property int $school_tool_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read AcademicLevel $academicLevel
 * @property-read SchoolTool|null $schoolTool
 *
 * @method static Builder<static>|AcademicLevelSchoolTool newModelQuery()
 * @method static Builder<static>|AcademicLevelSchoolTool newQuery()
 * @method static Builder<static>|AcademicLevelSchoolTool query()
 * @method static Builder<static>|AcademicLevelSchoolTool whereAcademicLevelId($value)
 * @method static Builder<static>|AcademicLevelSchoolTool whereCreatedAt($value)
 * @method static Builder<static>|AcademicLevelSchoolTool whereId($value)
 * @method static Builder<static>|AcademicLevelSchoolTool whereQty($value)
 * @method static Builder<static>|AcademicLevelSchoolTool whereSchoolToolId($value)
 * @method static Builder<static>|AcademicLevelSchoolTool whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
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
