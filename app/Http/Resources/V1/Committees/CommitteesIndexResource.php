<?php

namespace App\Http\Resources\V1\Committees;

use App\Models\Committee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Committee
 */
class CommitteesIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'members_count' => $this->members_count,
            'created_at' => Carbon::createFromTimeString($this->created_at)->diffForHumans(),
        ];
    }
}
