<?php

namespace App\Http\Resources\V1\Benefactors;

use App\Models\Benefactor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Benefactor */
class BenefactorsIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'phone' => formatPhoneNumber($this->phone),
            'sponsorships_count' => $this->sponsorships_count,
            'created_at' => Carbon::createFromTimeString($this->created_at)->diffForHumans(),
        ];
    }
}
