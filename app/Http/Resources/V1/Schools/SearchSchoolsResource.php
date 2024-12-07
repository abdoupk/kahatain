<?php

namespace App\Http\Resources\V1\Schools;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin School */
class SearchSchoolsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name.' ('.$this->city->commune_name.')',
        ];
    }
}
