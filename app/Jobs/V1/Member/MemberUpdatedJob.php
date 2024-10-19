<?php

namespace App\Jobs\V1\Member;

use App\Models\User;
use App\Notifications\Member\UpdateMemberNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;

class MemberUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $member, public User $user) {}

    public function handle(): void
    {
        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['list_members', 'view_members'],
                userToExclude: $this->user,
                notificationType: 'association_changes'
            ),
            new UpdateMemberNotification(
                member: $this->member,
                user: $this->user
            )
        );
    }
}
