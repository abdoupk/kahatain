<?php

namespace App\Http\Resources\V1\Occasions;

use App\Models\Baby;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Baby
 */
class BabyMilkAndDiapersResource extends JsonResource
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
            'orphan' => [
                'id' => $this->orphan->id,
                'name' => $this->orphan->getName(),
                'baby_milk_quantity' => $this->baby_milk_quantity,
                'baby_milk_type' => $this->babyMilk->name,
                'diapers_quantity' => $this->diapers_quantity,
                'diapers_type' => $this->diapers->name,
                'age' => calculateAge($this->orphan->birth_date),
            ],
        ];
    }
}
