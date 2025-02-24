<?php

namespace App\Http\Resources\V1\Families;

use App\Models\SecondSponsor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SecondSponsor */
class SecondSponsorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'degree_of_kinship' => $this->degree_of_kinship,
            'phone_number' => formatPhoneNumber($this->phone_number),
            'address' => $this->address,
            'income' => $this->income,
            'with_family' => $this->with_family,
        ];
    }
}
