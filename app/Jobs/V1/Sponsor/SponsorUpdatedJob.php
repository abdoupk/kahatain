<?php

namespace App\Jobs\V1\Sponsor;

use App\Models\Sponsor;
use App\Models\User;
use App\Notifications\Sponsor\UpdateSponsorNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notification;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SponsorUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Sponsor $sponsor, public User $user) {}

    /**
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfReaderException
     * @throws PdfTypeException
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function handle(): void
    {
        mergePdf($this->sponsor->load('incomes')->incomes->first());

        Notification::send(
            getUsersShouldBeNotified(
                permissions: ['view_sponsors'],
                userToExclude: $this->user,
                notificationType: 'families_changes'
            ),
            new UpdateSponsorNotification(
                sponsor: $this->sponsor,
                user: $this->user
            )
        );
    }
}
