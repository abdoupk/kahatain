<?php

namespace App\Http\Resources\V1\Financial;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Finance */
class FinancialIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => $this->date,
            'specification' => $this->specification,
            'creator' => new MemberResource($this->whenLoaded('creator')),
            'receiver' => new MemberResource($this->whenLoaded('receiver')),
        ];
    }
}
