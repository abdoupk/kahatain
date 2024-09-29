<?php

namespace App\Http\Resources\V1\Branches;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Branch
 */
class BranchesIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->whenLoaded('city', fn () => $this->city->getFullName(app()->getLocale())),
            'president' => $this->whenLoaded('president', fn () => [
                'id' => $this->president->id,
                'name' => $this->president->getName(),
            ]),
            'families_count' => $this->families_count,
            'created_at' => $this->created_at->translatedFormat('j F Y'),
        ];
    }
}
