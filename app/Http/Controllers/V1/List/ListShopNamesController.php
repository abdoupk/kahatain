<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\OrphanEidSuit;
use Illuminate\Http\Resources\Json\JsonResource;

class ListShopNamesController extends Controller
{
    public function __invoke()
    {
        $mergedNames = OrphanEidSuit::select('clothes_shop_name as name')
            ->whereNotNull('clothes_shop_name')
            ->union(
                OrphanEidSuit::select('shoes_shop_name as name')
                    ->whereNotNull('shoes_shop_name'))
            ->distinct()
            ->pluck('name');

        return JsonResource::collection(
            $mergedNames->map(function ($name) {
                return [
                    'label' => $name,
                    'value' => str_replace(' ', '_', strtolower($name)),
                ];
            })
        );
    }
}
