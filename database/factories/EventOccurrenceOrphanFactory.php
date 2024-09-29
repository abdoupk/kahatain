<?php

namespace Database\Factories;

use App\Models\EventOccurrenceOrphan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventOccurrenceOrphanFactory extends Factory
{
    protected $model = EventOccurrenceOrphan::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
