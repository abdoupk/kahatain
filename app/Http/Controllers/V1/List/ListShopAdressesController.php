<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\OrphanEidSuit;
use Illuminate\Http\Resources\Json\JsonResource;

class ListShopAdressesController extends Controller
{
    public function __invoke()
    {
        $mergedAdresses = OrphanEidSuit::select('clothes_shop_address as address')
            ->whereNotNull('clothes_shop_address')
            ->union(
                OrphanEidSuit::select('shoes_shop_address as address')
                    ->whereNotNull('shoes_shop_address'))
            ->distinct()
            ->pluck('address');

        return JsonResource::collection(
            $mergedAdresses->map(function ($address) {
                return [
                    'label' => $address,
                    'value' => str_replace(' ', '_', strtolower($address)),
                ];
            })
        );
    }
}
