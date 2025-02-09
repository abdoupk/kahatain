<?php

/** @noinspection UnknownInspectionInspection */

use App\Models\AcademicLevel;
use App\Models\Event;
use App\Models\EventOccurrence;
use App\Models\Orphan;
use App\Models\PrivateSchool;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Recurr\Exception\InvalidArgument;
use Recurr\Exception\InvalidWeekday;
use Recurr\Rule;
use Recurr\Transformer\ArrayTransformer;

/** @noinspection NullPointerExceptionInspection
 * @noinspection StaticClosureCanBeUsedInspection
 */
function getSchools(): LengthAwarePaginator
{
    return search(PrivateSchool::getModel())
        ->query(fn ($query) => $query->with('lessons')->withCount('eventsWithOrphans'))
        ->paginate(perPage: request()->integer('perPage', 10));
}

function getLessons(): Collection
{
    return Event::select(['id', 'title', 'color'])
        ->with(['occurrences' => function ($query): void {
            $query->select('id', 'event_id', 'start_date', 'end_date');
        },
        ])
        ->get()
        ->map(fn($event) => $event->occurrences->map(fn($occurrence) => [
            'id' => $occurrence->id,
            'title' => $event->title,
            'color' => $event->color,
            'start' => $occurrence->start_date,
            'end' => $occurrence->end_date,
            //                    'url' => route('tenant.lessons.details-lesson', $occurrence->id),
        ]))->flatten(1);
}

function formatedAcademicLevels(): array
{
    $formattedArray = [];

    foreach (AcademicLevel::all() as $row) {
        $formattedArray[$row['phase']]['phase'] = $row['phase'];

        $formattedArray[$row['phase']]['phase_key'] = $row['phase_key'];

        $formattedArray[$row['phase']]['levels'][] = ['name' => $row['level'], 'id' => $row['id']];
    }

    return array_values($formattedArray);
}

function getSchoolsForAddLesson(): Collection
{
    return search(PrivateSchool::getModel())
        ->query(fn ($query) => $query
            ->withCount('lessons')
            ->with(['lessons:id,private_school_id,quota,academic_level_id', 'subjects']))->get();
}

function getOrphansForAddLesson(): \Illuminate\Database\Eloquent\Collection
{
    return search(Orphan::getModel(), 'AND academic_level.id = '.request()->input('academic_level_id'))->get();
}

function formatDateFromTo($dateFrom, $dateTo): string
{
    return Carbon::parse($dateFrom)
        ->translatedFormat(
            'd M'.__('glue').' g:i A'
        ).' - '.Carbon::parse($dateTo)
        ->translatedFormat('g:i A');
}

/**
 * @throws InvalidWeekday
 * @throws InvalidArgument
 */
function generateOccurrences(Event $event, string $lesson_id, array $orphans): void
{
    $formatted = array_map(fn($orphan) => [
        'orphan_id' => $orphan,
        'lesson_id' => $lesson_id,
    ], $orphans);

    if (! $event->interval || ! $event->frequency) {
        $event_occurrence = $event->occurrences()->create([
            'start_date' => $event->start_date,
            'end_date' => $event->end_date,
            'tenant_id' => $event->tenant_id,
            'lesson_id' => $lesson_id,
        ]);

        $event_occurrence->orphans()->syncWithoutDetaching($formatted);

        return;
    }

    $frequency = $event->frequency;
    $interval = $event->interval;

    if ($event->frequency === 'weekly') {
        $frequency = 'daily';
        $interval = 7 * $event->interval;
    }

    $rule = new Rule;
    $rule->setStartDate($event->start_date);
    $rule->setEndDate($event->end_date);
    $rule->setFreq(Str::upper($frequency));
    $rule->setInterval($interval);
    $rule->setUntil($event->until ? Carbon::parse($event->until) : Carbon::create(now()->year, 7, 5));
    $rule->setWeekStart('SU');

    $transformer = new ArrayTransformer;
    $occurrences = $transformer->transform($rule);

    foreach ($occurrences as $occurrence) {
        $event_occurrence = EventOccurrence::create([
            'id' => Str::uuid()->toString(),
            'event_id' => $event->id,
            'lesson_id' => $lesson_id,
            'start_date' => $occurrence->getStart(),
            'end_date' => $occurrence->getEnd(),
            'tenant_id' => $event->tenant_id,
        ]);

        $event_occurrence->orphans()->syncWithoutDetaching($formatted);
    }
}
