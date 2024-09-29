<?php

namespace App\Http\Resources\V1\Archive;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Archive */
class ArchiveIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'occasion' => $this->occasion,
            'name' => $this->constructName(),
            'created_at' => $this->created_at,
            'readable_created_at' => $this->created_at->translatedFormat('j F Y H:i A'),
            'families_count' => $this->families_count + $this->orphans_count + $this->babies_count,

            'savedBy' => new MemberResource($this->whenLoaded('savedBy')),
            'url' => $this->constructUrl(),
        ];
    }

    private function constructName(): string
    {
        return match (true) {
            $this->occasion === 'monthly_basket' => __(
                'archive.monthly_basket',
                ['date' => $this->created_at->translatedFormat('F Y')]
            ),
            $this->occasion === 'ramadan_basket' => __(
                'archive.ramadan_basket',
                ['year' => $this->created_at->year]
            ),
            $this->occasion === 'eid_suit' => __(
                'archive.eid_suit',
                ['year' => $this->created_at->year]
            ),
            $this->occasion === 'eid_al_adha' => __(
                'archive.eid_al_adha',
                ['year' => $this->created_at->year]
            ),
            $this->occasion === 'school_entry' => __(
                'archive.school_entry',
                ['year' => $this->created_at->year]
            ),
            $this->occasion === 'babies_milk_and_diapers' => __(
                'archive.babies_milk_and_diapers',
                ['date' => $this->created_at->translatedFormat('F Y')]
            ),
        };
    }

    private function constructUrl(): string
    {
        return match (true) {
            $this->occasion === 'monthly_basket' => route(
                'tenant.archive.details.monthly-basket',
                $this->id
            ),
            $this->occasion === 'ramadan_basket' => route(
                'tenant.archive.details.ramadan-basket',
                $this->id
            ),
            $this->occasion === 'eid_suit' => route(
                'tenant.archive.details.eid-suit',
                $this->id
            ),
            $this->occasion === 'eid_al_adha' => route(
                'tenant.archive.details.eid-al-adha',
                $this->id
            ),
            $this->occasion === 'school_entry' => route(
                'tenant.archive.details.school-entry',
                $this->id
            ),
            $this->occasion === 'babies_milk_and_diapers' => route(
                'tenant.archive.details.babies-milk-and-diapers',
                $this->id
            )
        };
    }
}
