<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property string $commune_name
 * @property string $commune_name_ascii
 * @property string $daira_name
 * @property string $daira_name_ascii
 * @property string $wilaya_code
 * @property string $wilaya_name
 * @property string $wilaya_name_ascii
 * @property string $latitude
 * @property string $longitude
 * @property string $post_code
 * @property string|null $commune_code
 *
 * @method static Builder<static>|City newModelQuery()
 * @method static Builder<static>|City newQuery()
 * @method static Builder<static>|City query()
 * @method static Builder<static>|City whereCommuneCode($value)
 * @method static Builder<static>|City whereCommuneName($value)
 * @method static Builder<static>|City whereCommuneNameAscii($value)
 * @method static Builder<static>|City whereDairaName($value)
 * @method static Builder<static>|City whereDairaNameAscii($value)
 * @method static Builder<static>|City whereId($value)
 * @method static Builder<static>|City whereLatitude($value)
 * @method static Builder<static>|City whereLongitude($value)
 * @method static Builder<static>|City wherePostCode($value)
 * @method static Builder<static>|City whereWilayaCode($value)
 * @method static Builder<static>|City whereWilayaName($value)
 * @method static Builder<static>|City whereWilayaNameAscii($value)
 *
 * @mixin Eloquent
 */
class City extends Model
{
    use Searchable;

    public $timestamps = false;

    protected $fillable = [
        'commune_name',
        'commune_name_ascii',
        'daira_name',
        'daira_name_ascii',
        'wilaya_code',
        'wilaya_name',
        'wilaya_name_ascii',
        'latitude',
        'longitude',
        'post_code',
        'commune_code',
    ];

    public function getFullName(?string $locale = 'ar'): string
    {
        if ($locale === 'ar') {
            return $this->wilaya_name.trans('glue').$this->daira_name.'، '.$this->commune_name;
        }

        return $this->wilaya_name_ascii.', '.$this->daira_name_ascii.', '.$this->commune_name_ascii;
    }
}
