<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property float|null $min_price
 * @property float|null $max_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static>|SchoolTool newModelQuery()
 * @method static Builder<static>|SchoolTool newQuery()
 * @method static Builder<static>|SchoolTool query()
 * @method static Builder<static>|SchoolTool whereCreatedAt($value)
 * @method static Builder<static>|SchoolTool whereId($value)
 * @method static Builder<static>|SchoolTool whereMaxPrice($value)
 * @method static Builder<static>|SchoolTool whereMinPrice($value)
 * @method static Builder<static>|SchoolTool whereName($value)
 * @method static Builder<static>|SchoolTool whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class SchoolTool extends Model
{
    protected $fillable = [
        'name',
        'min_price',
        'max_price',
    ];
}
