<?php

namespace App\Http\Resources\V1\Occasions;

use App\Models\OrphanSponsorship;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin OrphanSponsorship
 */
class EidSuitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sponsor' => [
                'id' => $this->orphan->sponsor?->id,
                'name' => $this->orphan->sponsor?->getName(),
                'phone_number' => $this->orphan->sponsor?->formattedPhoneNumber(),
            ],
            'family' => [
                'zone' => [
                    'id' => $this->orphan->family->zone?->id,
                    'name' => $this->orphan->family->zone?->name,
                ],
                'address' => $this->orphan->family->address,
            ],
            'orphan' => [
                'id' => $this->orphan->id,
                'name' => $this->orphan->getName(),
                'shirt_size' => $this->orphan->shirtSize->label,
                'pants_size' => $this->orphan->pantsSize->label,
                'shoes_size' => $this->orphan->shoesSize->label,
                'age' => $this->orphan->birth_date->age ?? null,
            ],
        ];
    }
}
