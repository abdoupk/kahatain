<?php

namespace App\Http\Resources\V1\Financial;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Finance */
class FinancialUpdateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => $this->date->format('Y/m/d'),
            'specification' => $this->specification,
            'member_id' => $this->received_by,
            'creator' => new MemberResource($this->whenLoaded('creator')),
        ];
    }
}
