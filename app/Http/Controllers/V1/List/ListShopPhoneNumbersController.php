<?php

namespace App\Http\Controllers\V1\List;

use App\Http\Controllers\Controller;
use App\Models\OrphanEidSuit;
use Illuminate\Http\Resources\Json\JsonResource;

class ListShopPhoneNumbersController extends Controller
{
    public function __invoke()
    {
        $mergedPhoneNumbers = OrphanEidSuit::select('clothes_shop_phone_number as phone_number')
            ->whereNotNull('clothes_shop_phone_number')
            ->union(
                OrphanEidSuit::select('shoes_shop_phone_number as phone_number')
                    ->whereNotNull('shoes_shop_phone_number'))
            ->distinct()
            ->pluck('phone_number');

        return JsonResource::collection(
            $mergedPhoneNumbers->map(function ($phoneNumber) {
                return [
                    'label' => $phoneNumber,
                    'value' => str_replace(' ', '_', strtolower($phoneNumber)),
                ];
            })
        );
    }
}
