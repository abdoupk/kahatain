<?php

namespace App\Http\Resources\V1\Families;

use App\Models\Preview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Preview */
class FamilyEditPreviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'report' => $this->report,
            'preview_date' => $this->preview_date,
            'inspectors' => $this->whenLoaded('inspectors', fn () => $this->inspectors->pluck('id')),
        ];
    }
}
