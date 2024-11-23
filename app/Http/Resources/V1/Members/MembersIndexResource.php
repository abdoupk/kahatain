<?php

namespace App\Http\Resources\V1\Members;

use App\Http\Resources\V1\Zones\ZoneResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class MembersIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'email' => $this->email,
            'phone' => formatPhoneNumber($this->phone),
            'zone' => ZoneResource::make($this->whenLoaded('zone')),
            'created_at' => $this->created_at,
        ];
    }
}
