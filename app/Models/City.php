<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

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
