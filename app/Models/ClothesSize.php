<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

/**
 * @property int $id
 * @property string|null $label
 *
 * @method static Builder|ClothesSize newModelQuery()
 * @method static Builder|ClothesSize newQuery()
 * @method static Builder|ClothesSize query()
 * @method static Builder|ClothesSize whereId($value)
 * @method static Builder|ClothesSize whereLabel($value)
 *
 * @mixin Eloquent
 */
class ClothesSize extends Model
{
    use Sushi;

    protected array $rows = [
        [
            'id' => 1,
            'label' => 'XXS',
        ],
        [
            'id' => 2,
            'label' => 'XS',
        ],
        [
            'id' => 3,
            'label' => '32',
        ],
        [
            'id' => 4,
            'label' => '34',
        ],
        [
            'id' => 5,
            'label' => '36',
        ],
        [
            'id' => 6,
            'label' => 'S',
        ],
        [
            'id' => 7,
            'label' => '38',
        ],
        [
            'id' => 8,
            'label' => 'M',
        ],
        [
            'id' => 9,
            'label' => '40',
        ],
        [
            'id' => 10,
            'label' => 'L',
        ],
        [
            'id' => 11,
            'label' => 'XL',
        ],
        [
            'id' => 12,
            'label' => '42',
        ],
        [
            'id' => 13,
            'label' => '2XL',
        ],
        [
            'id' => 14,
            'label' => '3XL',
        ],
        [
            'id' => 15,
            'label' => '4XL',
        ],
    ];
}
