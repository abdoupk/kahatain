<?php

namespace App\Http\Resources\V1\Members;

use App\Http\Resources\V1\Roles\RoleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class MemberUpdateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'address' => $this->address,
            'location' => $this->location,
            'competences' => $this->competences,
            'committees' => $this->committees,

            'zone' => $this->whenLoaded('zone', fn () => [
                'id' => $this->zone?->id,
                'name' => $this->zone?->name,
            ]),
            'branch' => $this->whenLoaded('branch', fn () => [
                'id' => $this->branch?->id,
                'name' => $this->branch?->name,
            ]),
            'academic_level_id' => $this->academic_level_id,
            'roles' => RoleResource::collection($this->roles),
        ];
    }
}
