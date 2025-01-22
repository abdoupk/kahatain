<?php

namespace App\Http\Resources\V1\Needs;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Need;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Need */
class NeedShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'demand' => $this->demand,
            'subject' => $this->subject,
            'status' => $this->status,
            'needable' => [
                'id' => $this->needable_id,
                'name' => $this->needable?->getName(),
                'type' => $this->needable_type,
            ],
            'creator' => new MemberResource($this->whenLoaded('creator')),
            'note' => $this->note,
            'readable_created_at' => $this->created_at->translatedFormat('d F Y H:i A'),
        ];
    }
}
