<?php

namespace App\Http\Resources\V1\Needs;

use App\Models\Need;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Need */
class NeedsIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'demand' => $this->demand,
            'subject' => $this->subject,
            'status' => $this->status,
            'zone' => [
                'id' => $this->needable->family?->zone?->id,
                'name' => $this->needable->family?->zone?->name,
            ],
            'branch' => [
                'id' => $this->needable->family?->branch?->id,
                'name' => $this->needable->family?->branch?->name,
            ],
            'needable' => [
                'id' => $this->needable_id,
                'name' => $this->needable?->getName(),
                'type' => $this->needable_type,
            ],
            'note' => $this->note,
            'created_at' => $this->created_at,
            'readable_created_at' => $this->created_at->translatedFormat('j F Y H:i A'),
        ];
    }
}
