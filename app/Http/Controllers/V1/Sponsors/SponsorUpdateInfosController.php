<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sponsors\SponsorInfosUpdateRequest;
use App\Jobs\V1\Sponsor\SponsorUpdatedJob;
use App\Models\Sponsor;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SponsorUpdateInfosController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_sponsors'];
    }

    /**
     * @return ResponseFactory|Application|Response
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws PdfReaderException
     */
    public function __invoke(SponsorInfosUpdateRequest $request, Sponsor $sponsor)
    {
        $sponsor->update($request->except(['photo', 'diploma_file', 'birth_certificate_file', 'no_remarriage_file']));

        if ($request->sponsor_type !== $sponsor->sponsor_type) {
            monthlySponsorship($sponsor->load('family')->family);
        }

        $sponsor->orphans->searchable();

        addToMediaCollection($sponsor, $request->diploma_file, 'diploma_files');

        addToMediaCollection($sponsor, $request->birth_certificate_file, 'birth_certificate_files');

        addToMediaCollection($sponsor, $request->no_remarriage_file, 'no_remarriage_files');

        addToMediaCollection($sponsor, $request->photo, 'photos');

        mergePdf($sponsor);

        dispatch(new SponsorUpdatedJob($sponsor, auth()->user()));

        return response('', 201);
    }
}
