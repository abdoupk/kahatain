<?php

namespace App\Http\Controllers\V1\Occasions\EidSuit;

use App\Events\EidSuitInfosUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Occasions\EidSuit\BulkUpdateEidSuitInfosRequest;
use App\Jobs\V1\Occasion\EidSuitBulkUpdateInfosJob;
use App\Models\Orphan;

class BulkUpdateEidSuitInfosController extends Controller
{
    public function __invoke(BulkUpdateEidSuitInfosRequest $request)
    {
        Orphan::whereIn('id', $request->ids)->each(function (Orphan $orphan) use ($request): void {
            $orphan->eidSuit()->updateOrCreate(
                ['orphan_id' => $orphan->id],
                [
                    'shoes_shop_location' => $request->shoes_shop_location,
                    'shoes_shop_name' => $request->shoes_shop_name,
                    'shoes_shop_address' => $request->shoes_shop_address,
                    'shoes_shop_phone_number' => $request->shoes_shop_phone_number,
                    'clothes_shop_name' => $request->clothes_shop_name,
                    'clothes_shop_address' => $request->clothes_shop_address,
                    'clothes_shop_location' => $request->clothes_shop_location,
                    'clothes_shop_phone_number' => $request->clothes_shop_phone_number,
                    'user_id' => $request->designated_member,
                ],
            );

            $orphan->searchable();
        });

        EidSuitInfosUpdatedEvent::dispatch($request->ids, auth()->user());

        dispatch(new EidSuitBulkUpdateInfosJob($request->validated('ids'), auth()->user()));

        return response('', 201);
    }
}
