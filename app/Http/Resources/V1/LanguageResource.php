<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $value
 *
 * @method label()
 * @method direction()
 * @method flag()
 */
class LanguageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->value,
            'label' => $this->label(),
            'flag' => $this->flag(),
            'direction' => $this->direction(),
        ];
    }
}
