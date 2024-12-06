<?php

namespace App\Http\Controllers\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\EventOccurrence;
use App\Models\Family;
use App\Models\Finance;
use App\Models\Need;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $family = Family::with(['archives', 'orphans.archives', 'babies.archives'])
            ->find('9da94371-79df-40cf-b99e-c47caf6763e8');

        $allArchives = $family->archives->merge(
            $family->orphans->flatMap(function ($orphan) {
                return $orphan->archives;
            })
        );

        $allArchives = $allArchives->merge(
            $family->babies->flatMap(function ($baby) {
                return $baby->archives;
            })
        );

        ray($allArchives);

        return Inertia::render('Tenant/dashboard/TheDashboardPage', [
            'reports' => fn () => generateGlobalDashBoardReportStatistics(),
            'financialReports' => fn () => generateFinancialReport(),
            'recentActivities' => fn () => $this->getRecentActivities(),
            'recentTransactions' => fn () => $this->getRecentTransactions(),
            'comingEvents' => fn () => $this->getComingEvents(),
            'recentFamilies' => fn () => $this->getRecentFamilies(),
            'recentNeeds' => fn () => $this->getRecentNeeds(),
            'familiesByZone' => fn () => getFamiliesGroupedByZone(),
            'familiesByBranch' => fn () => getFamiliesGroupedByBranch(),
            'orphansByGender' => fn () => getOrphansByGender(),
            'orphansGroupByCreatedDate' => fn () => getOrphansGroupByCreatedDate(),
            'needsByNeedableType' => fn () => getNeedsGroupByType(),
            'needsByCreatedDate' => fn () => getNeedsGroupByCreatedDate(),
            'familiesForMap' => fn () => getFamiliesPosition(),
        ]);
    }

    private function getRecentActivities()
    {
        return auth()->user()->notifications->take(5)->map(function ($notification) {
            return [
                'id' => $notification->id,
                'user' => [
                    'id' => $notification->data['user']['id'],
                    'name' => $notification->data['user']['name'],
                    'gender' => $notification->data['user']['gender'],
                ],
                'formatted_date' => $notification->created_at->translatedFormat('H:i A'),
                'date' => $notification->created_at,
                'message' => trans_choice(
                    'notifications.'.$notification->type,
                    $notification->data['user']['gender'] === 'male' ? 1 : 0,
                    $notification->data['data']
                ),
            ];
        })->toArray();
    }

    private function getRecentTransactions(): array
    {
        return Finance::query()->
        with('receiver:id,first_name,last_name,gender')
            ->select(['id', 'amount', 'received_by', 'date'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Finance $finance) {
                return [
                    'id' => $finance->id,
                    'amount' => $finance->amount,
                    'receiver' => [
                        'id' => $finance->receiver?->id,
                        'name' => $finance->receiver?->getName(),
                        'gender' => $finance->receiver?->gender,
                    ],
                    'date' => $finance->date->translatedFormat('j F Y'),
                ];
            })->toArray();
    }

    private function getComingEvents(): array
    {
        return EventOccurrence::with('event')
            ->whereMonth('start_date', '=', date('m'))
            ->take(3)
            ->get()
            ->map(function (EventOccurrence $eventOccurrence) {
                return [
                    'id' => $eventOccurrence->id,
                    'title' => $eventOccurrence->event->title,
                    'date' => $eventOccurrence->start_date,
                    'color' => $eventOccurrence->event->color,
                ];
            })->toArray();
    }

    private function getRecentFamilies(): array
    {
        return Family::with(['zone:id,name', 'branch:id,name'])
            ->select(['id', 'name', 'branch_id', 'zone_id', 'address'])->withCount(['orphans'])
            ->latest()
            ->take(4)
            ->get()
            ->map(function (Family $family) {
                return [
                    'id' => $family->id,
                    'name' => $family->name,
                    'address' => $family->address,
                    'zone' => [
                        'id' => $family->zone?->id,
                        'name' => $family->zone?->name,
                    ],
                    'branch' => [
                        'id' => $family->branch?->id,
                        'name' => $family->branch?->name,
                    ],
                    'orphans_count' => $family->orphans_count,
                ];
            })->toArray();
    }

    private function getRecentNeeds(): array
    {
        return Need::whereHas('needable')
            ->select(['id', 'demand', 'subject', 'status', 'needable_id', 'needable_type', 'created_at'])
            ->with('needable')
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Need $need) {
                return [
                    'id' => $need->id,
                    'status' => $need->status,
                    'subject' => $need->subject,
                    'demand' => $need->demand,
                    'date' => $need->created_at->diffForHumans(),
                    'needable' => [
                        'id' => $need->needable?->id,
                        'name' => $need->needable?->getName(),
                        'type' => $need->needable_type,
                    ],
                ];
            })->toArray();
    }
}
