<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection NullPointerExceptionInspection */

use App\Helpers\PdfMerger;
use App\Models\Family;
use App\Models\Income;
use App\Models\Orphan;
use App\Models\Sponsor;
use App\Models\Spouse;
use App\Models\Tenant;
use App\Models\UniversitySpeciality;
use App\Models\User;
use App\Models\VocationalTrainingSpeciality;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Builder;
use LaravelIdea\Helper\App\Models\_IH_User_C;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @throws Throwable
 * @throws CouldNotTakeBrowsershot
 */
function saveToPDF(string $directory, string $variableName, callable $function, string|null|Carbon $date = null, string $attribute = '', string $pageType = 'A4', ?bool $landscape = true): StreamedResponse
{
    $disk = Storage::disk('public');

    if (! $disk->directoryExists($directory)) {
        $disk->makeDirectory($directory);
    }

    $pdfName = Str::replace('-', '_', explode('/', "$directory/$variableName")[1]);

    $pdfName = __('exports.'.$pdfName, [
        'date' => $date,
        'attribute' => $attribute,
    ]);

    $pdfFile = "$directory/$pdfName".'.pdf';

    $pdfPath = $disk->path($pdfFile);

    $browsershot = Browsershot::html(view("pdf.$directory", [
        $variableName => $function(),
        'title' => $pdfName,
    ])
        ->render())
        ->ignoreHttpsErrors()
        ->noSandbox()
        ->format($pageType);

    if (! app()->environment('local')) {
        $browsershot->setNodeBinary(config('app.browsershot.node_binary'));
        $browsershot->setNpmBinary(config('app.browsershot.npm_binary'));
    }

    $browsershot->margins(2, 4, 2, 4);

    if ($landscape === true) {
        $browsershot->landscape();
    }

    $browsershot->save($pdfPath);

    return $disk->download($pdfFile);
}

/**
 * @throws Throwable
 * @throws CouldNotTakeBrowsershot
 */
function saveArchiveToPDF(
    string $directory,
    callable $function,
    string $date,
    ?string $variableName = 'families',
    ?string $attribute = '',
    string $pageType = 'A4'
): StreamedResponse {
    $disk = Storage::disk('public');

    if (! $disk->directoryExists("archives/$directory")) {
        $disk->makeDirectory($directory);
    }

    $pdfName = __('exports.archive.'.Str::replace(
        '-',
        '_',
        explode(
            '/',
            "archives/$directory/sponsorships"
        )[1]
    ), ['date' => $date, 'attribute' => $attribute]);

    $pdfFile = "$directory/".Str::slug($pdfName, '-', 'ar').'.pdf';

    $pdfPath = $disk->path($pdfFile);

    $browsershot = Browsershot::html(view("pdf.occasions.$directory", [
        $variableName => $function(),
        'title' => $pdfName,
    ])
        ->render())
        ->ignoreHttpsErrors()
        ->noSandbox()
        ->format($pageType);

    if (! app()->environment('local')) {
        $browsershot->setNodeBinary(config('app.browsershot.node_binary'));
        $browsershot->setNpmBinary(config('app.browsershot.npm_binary'));
    }

    $browsershot->margins(2, 4, 2, 4)
        ->landscape()
        ->save($pdfPath);

    return $disk->download($pdfFile);
}

function getParams(): array
{
    return [
        /* @phpstan-ignore-next-line */
        'page' => (int) request()->input('page', 1),
        'search' => request()->input('search', ''),
        'perPage' => request()->integer('perPage', 10),
        'fields' => request()->input('fields'),
        'directions' => request()->input('directions'),
        'filters' => request()->input('filters'),
    ];
}

function generateFormatedConditions(): array
{
    $filters = (array) request()->input('filters', []);

    if ($filters !== []) {
        /** @phpstan-ignore-next-line */
        return array_map(static fn (array $condition) => [
            $condition['field'],
            $condition['operator'],
            str_contains((string) $condition['value'], ' ')
                ? '"'.$condition['value'].'"'
                : $condition['value'],
        ], $filters);
    }

    return [];
}

function generateFilterConditions(?string $additional_filters = ''): string
{
    $filters = array_merge(generateFormatedConditions());

    if ($filters === []) {
        return 'tenant_id = '.tenant('id').' '.$additional_filters;
    }

    return implode(' AND ', array_map(static fn ($condition) => implode(' ', $condition), $filters)).' '.$additional_filters;
}

function generateFormattedSort(): array
{
    $directions = (array) request()->input('directions', []);

    if ($directions !== []) {
        /** @phpstan-ignore-next-line */
        return array_map(static function (string $value, string $key) {
            if ($key === 'birth_date' || $key === 'orphan.birth_date') {
                return $value === 'desc' ? "$key:asc" : "$key:desc";
            }

            return "$key:$value";
        }, array_values($directions), array_keys($directions));
    }

    return ['created_at:desc'];
}

function search(Model $model, ?string $additional_filters = '', ?int $limit = null): Builder
{
    if ($limit === null || $limit === 0) {
        $limit = request()->integer('perPage', 10);
    }

    if (property_exists($model, 'deleted_at')) {
        $additional_filters .= ' AND __soft_deleted = 0';
    }

    $query = trim((string) request()->input('search', '')) ?? '';

    $meilisearchOptions = [
        'filter' => generateFilterConditions($additional_filters).' AND tenant_id = '.tenant('id'),
        'sort' => generateFormattedSort(),
        'limit' => $limit,
    ];

    if (Schema::hasColumn($model->getTable(), 'deleted_at')) {
        $meilisearchOptions['filter'] .= ' AND __soft_deleted = 0';
    }

    return $model::search(
        $query,
        static function (
            $meilisearch,
            string $query,
            array $options
        ) use ($meilisearchOptions) {
            unset($options['filter']);

            return $meilisearch->search($query, $options + $meilisearchOptions);
        }
    );
}

function formatedVocationalTrainingSpecialities(): array
{
    $formattedArray = [];

    $rows = VocationalTrainingSpeciality::get();

    foreach ($rows as $row) {
        $formattedArray[$row['division']]['division'] = $row['division'];

        $formattedArray[$row['division']]['specialities'][] = ['name' => $row['speciality'], 'id' => $row['id']];
    }

    return array_values($formattedArray);
}

function searchVocationalTrainingSpecialities(): \Illuminate\Support\Collection
{
    $vocationalTrainingSpecialities = VocationalTrainingSpeciality::search(trim((string) request()->input('search', '')) ?? '', function ($meilisearch, $query, array $options) {
        $options['limit'] = 100;

        return $meilisearch->search($query, $options);
    })->get()->map(fn ($vocationalTrainingSpeciality) => [
        'name' => $vocationalTrainingSpeciality->speciality,
        'id' => $vocationalTrainingSpeciality->speciality,
    ]);

    $universitySpecialities = UniversitySpeciality::search(trim((string) request()->input('search', '')) ?? '', function ($meilisearch, $query, array $options) {
        $options['limit'] = 100;

        return $meilisearch->search($query, $options);
    })->get()->map(fn ($universitySpeciality) => [
        'name' => $universitySpeciality->speciality,
        'id' => $universitySpeciality->speciality,
    ]);

    return collect(array_merge($vocationalTrainingSpecialities->toArray(), $universitySpecialities->toArray()));
}

function formatCurrency(?float $amount): false|string
{
    $formatter = new NumberFormatter(app()->getLocale().'_DZ', NumberFormatter::CURRENCY);

    if ($amount) {
        return $formatter->formatCurrency($amount, 'DZD');
    }

    return $formatter->formatCurrency(0, 'DZD');
}

function calculateAge($birthDate): string
{
    $diff = date_diff($birthDate, now());
    $dates = [];

    if ($diff->y > 0) {
        $dates[] = trans_choice('age_years', $diff->y, ['value' => $diff->y]);
    }

    if ($diff->m > 0) {
        $dates[] = trans_choice('age_months', $diff->m, ['value' => $diff->m]);
    }

    if ($diff->d > 0) {
        $dates[] = trans_choice('age_days', $diff->d, ['value' => $diff->d]);
    }

    return implode(trans('finale_glue'), $dates);
}

function formatPhoneNumber($phone): string
{
    return substr((string) $phone, 0, 4).'-'.
        substr((string) $phone, 4, 2).'-'.
        substr((string) $phone, 6, 2).'-'.
        substr((string) $phone, 8, 2);
}

function getUsersShouldBeNotified(
    array $permissions,
    User $userToExclude,
    string $notificationType
): Collection|array|_IH_User_C {
    setPermissionsTeamId($userToExclude->tenant_id);

    return User::with(['roles.permissions'])
        ->whereHas(
            'settings',
            fn ($query) => $query->where("notifications->$notificationType", true)
        )
        ->where(function ($query) use ($permissions): void {
            $query->whereHas('roles', function ($query): void {
                $query->where('name', 'super_admin');
            })
                ->orWhere(function ($query) use ($permissions): void {
                    $query->whereHas(
                        'roles.permissions',
                        function ($query) use ($permissions): void {
                            $query->whereIn('name', $permissions);
                        }
                    );
                });
        })
        ->where('users.id', '!=', $userToExclude->id)
        ->get();
}

function getFileNameFromTemporaryPath($url): string
{
    if ($url === '' || $url === null) {
        return '';
    }
    $path = parse_url((string) $url, PHP_URL_PATH);

    return substr($path, strpos($path, 'tmp/'));
}

/**
 * @throws FileIsTooBig
 * @throws FileDoesNotExist
 */
function addToMediaCollection(Family|Tenant|Orphan|Sponsor|Spouse|Income $model, string|array|null $files, string $collectionName, ?bool $clearCollection = true): void
{
    if ($clearCollection === true) {
        $model->clearMediaCollection($collectionName);
    }

    if ($files === null || $files === '') {
        return;
    }

    if (! is_array($files)) {
        $files = [$files];
    }

    foreach ($files as $file) {
        if (Storage::disk('public')->exists(getFileNameFromTemporaryPath($file))) {
            $model->addMediaFromDisk(getFileNameFromTemporaryPath($file), 'public')->toMediaCollection($collectionName);
        }
    }
}

/**
 * @throws CrossReferenceException
 * @throws FileDoesNotExist
 * @throws FileIsTooBig
 * @throws FilterException
 * @throws PdfParserException
 * @throws PdfReaderException
 * @throws PdfTypeException
 */
function mergePdf(Family|Tenant|Orphan|Sponsor|Spouse|Income $model): void
{
    $pdfFiles = [];

    $model->clearMediaCollection('merged_files');

    $model->getMedia('*')->each(function (Media $media) use (&$pdfFiles): void {
        if ($media->type === 'pdf') {
            $pdfFiles[] = $media->getPath();
        }
    });

    if ($pdfFiles !== []) {
        $fileName = Str::random(20).'.pdf';

        (new PdfMerger)->merge($pdfFiles, storage_path($fileName));

        $model->addMedia(storage_path($fileName))->toMediaCollection('merged_files');
    }
}

function getImageData(Income|Family|Sponsor|Spouse $model, string $collection): array
{
    [$width, $height] = getimagesize($model->getFirstMediaPath($collection));

    return [
        'thumb' => $model->getFirstMediaUrl($collection, 'thumb'),
        'original' => $model->getFirstMediaUrl($collection),
        'width' => $width,
        'height' => $height,
    ];
}

function getFormatedData(Sponsor|Family|Income|Spouse $model): array
{
    return [
        'files' => [
            'pdf' => $model->getFirstMediaUrl('merged_files'),
            'images' => array_filter($model->getMedia('*')->map(function (Media $media) use ($model) {
                if ($media->type === 'image') {
                    return getImageData($model, $media->collection_name);
                }
            })->toArray()),
        ],
    ];
}
