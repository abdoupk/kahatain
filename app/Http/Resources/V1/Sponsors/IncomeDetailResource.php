<?php

namespace App\Http\Resources\V1\Sponsors;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Income */
class IncomeDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cnr' => $this->cnr,
            'cnas' => $this->cnas,
            'casnos' => $this->casnos,
            'pension' => $this->pension,
            'account' => $this->account,
            'other_income' => $this->other_income,
            'total_income' => $this->total_income,
            ...getFormatedData($this->resource),
        ];
    }
}
