<?php

namespace App\Http\Resources\V1\Financial;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Finance */
class FinancialTransactionDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'description' => $this->description,
            'specification' => $this->specification,

            'creator' => new MemberResource($this->whenLoaded('creator')),
            'receiver' => new MemberResource($this->whenLoaded('receiver')),
            'readable_created_at' => $this->created_at->translatedFormat('j F Y H:i A'),
            'readable_date' => $this->date->translatedFormat('j F Y H:i A'),
        ];
    }
}
