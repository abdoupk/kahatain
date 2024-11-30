<?php

namespace App\Http\Resources\V1\Sponsors;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
            'files' => [
                'pdf' => $this->getFirstMediaUrl('merged_files'),
                'images' => array_filter($this->getMedia('*')->map(function (Media $media) {
                    if ($media->type === 'image') {
                        return $this->getImageData($media->collection_name);
                    }
                })->toArray()),
            ],
        ];
    }

    private function getImageData(string $collection): array
    {
        [$width, $height] = getimagesize($this->getFirstMediaPath($collection));

        return [
            'thumb' => $this->getFirstMediaUrl($collection, 'thumb'),
            'original' => $this->getFirstMediaUrl($collection),
            'width' => $width,
            'height' => $height,
        ];
    }
}
