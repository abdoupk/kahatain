<?php

namespace App\Http\Resources\V1\Occasions;

use App\Models\Orphan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Orphan
 */
class EidSuitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sponsor' => [
                'id' => $this->sponsor?->id,
                'name' => $this->sponsor?->getName(),
                'phone_number' => $this->sponsor?->formattedPhoneNumber(),
            ],
            'family' => [
                'zone' => [
                    'id' => $this->family->zone?->id,
                    'name' => $this->family->zone?->name,
                ],
                'address' => $this->family?->address,
                'income_rate' => $this->family?->income_rate,
            ],
            'orphan' => [
                'id' => $this->id,
                'name' => $this->getName(),
                'shirt_size' => $this->shirtSize?->label,
                'pants_size' => $this->pantsSize?->label,
                'shoes_size' => $this->shoesSize?->label,
                'age' => $this->birth_date->age ?? null,
            ],
        ];
    }
}
