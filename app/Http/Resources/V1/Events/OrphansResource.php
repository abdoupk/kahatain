<?php

namespace App\Http\Resources\V1\Events;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Orphan */
class OrphansResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'sponsor_phone' => $this->sponsor->formattedPhoneNumber(),
            'name' => $this->getName(),
        ];
    }
}
