<?php

namespace App\Http\Resources\V1\Needs;

use App\Models\Need;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Need */
class NeedUpdateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'demand' => $this->demand,
            'subject' => $this->subject,
            'note' => $this->note,
            'status' => $this->status,
            'needable_id' => $this->needable_id,
            'needable_type' => $this->needable_type,
        ];
    }
}
