<?php

namespace App\Http\Resources\V1\Members;

use App\Http\Resources\V1\Zones\ZoneResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 *
 * @method string getName()
 */
class MemberDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'email' => $this->email,
            'gender' => $this->gender,
            'qualification' => $this->qualification,
            'phone' => formatPhoneNumber($this->phone),
            'zone' => ZoneResource::make($this->whenLoaded('zone')),
            'readable_created_at' => $this->created_at->translatedFormat('j F Y H:i A'),
            'creator' => MemberResource::make($this->whenLoaded('creator')),
            'readable_roles' => $this->roles->pluck('name')->implode(__('glue')),
        ];
    }
}
