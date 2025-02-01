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
 *
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City whereCommuneName($value)
 * @method static Builder|City whereCommuneNameAscii($value)
 * @method static Builder|City whereDairaName($value)
 * @method static Builder|City whereDairaNameAscii($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereLatitude($value)
 * @method static Builder|City whereLongitude($value)
 * @method static Builder|City wherePostCode($value)
 * @method static Builder|City whereWilayaCode($value)
 * @method static Builder|City whereWilayaName($value)
 * @method static Builder|City whereWilayaNameAscii($value)
 *
 * @property string|null $commune_code
 *
 * @method static Builder<static>|City whereCommuneCode($value)
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
