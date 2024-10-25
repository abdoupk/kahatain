<?php

namespace App\Http\Resources\V1\Committees;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Committee */
class CommitteeShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'readable_created_at' => $this->created_at->translatedFormat('j F Y H:i A'),
            'creator' => new MemberResource($this->whenLoaded('creator')),

            'members_count' => $this->members_count,
        ];
    }
}
