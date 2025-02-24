<?php

namespace App\Http\Resources\V1\Families;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Income */
class IncomeResource extends JsonResource
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
            'cnas_file' => $this->getFirstMediaUrl('cnas_files'),
            'cnr_file' => $this->getFirstMediaUrl('cnr_files'),
            'casnos_file' => $this->getFirstMediaUrl('casnos_files'),
            'bank_file' => $this->getFirstMediaUrl('bank_files'),
            'ccp_file' => $this->getFirstMediaUrl('ccp_files'),
        ];
    }
}
