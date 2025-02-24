<?php

namespace App\Http\Resources\V1\SiteSetting;

use App\Http\Resources\V1\Cities\CityResource;
use App\Models\City;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Tenant */
class SiteSettingsIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $city = City::whereId($this->infos['city_id'] ?? null)->first();

        return [
            'association' => $this->infos['association'],
            'city' => CityResource::make($city),
            'city_id' => $this->infos['city_id'] ?? null,
            'domain' => explode('.', (string) $this->infos['domain'])[0],
            'super_admin' => [
                'id' => $this->infos['super_admin']['id'],
            ],
            'address' => $this->infos['address'] ?? null,
            'logo' => $this->getFirstMedia('logos')?->getUrl() ?? null,
        ];
    }
}
