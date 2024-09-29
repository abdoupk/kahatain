<?php

namespace App\Http\Resources\V1\Families;

use App\Models\Spouse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Spouse */
class SpouseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birth_date' => $this->birth_date,
            'death_date' => $this->death_date,
            'function' => $this->function,
            'income' => $this->income,
        ];
    }
}
