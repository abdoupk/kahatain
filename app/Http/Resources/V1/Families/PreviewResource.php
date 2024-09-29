<?php

namespace App\Http\Resources\V1\Families;

use App\Models\Preview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Preview */
class PreviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'report' => $this->report,
            'preview_date' => $this->preview_date,
            'inspectors' => $this->whenLoaded('inspectors', function () {
                return $this->inspectors->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->getName(),
                    ];
                })->toArray();
            }),
        ];
    }
}
