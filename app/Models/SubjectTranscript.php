<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property int $subject_id
 * @property float|null $grade
 * @property string $tenant_id
 * @property string $transcript_id
 * @property-read Tenant|null $tenant
 *
 * @method static Builder<static>|SubjectTranscript newModelQuery()
 * @method static Builder<static>|SubjectTranscript newQuery()
 * @method static Builder<static>|SubjectTranscript query()
 * @method static Builder<static>|SubjectTranscript whereGrade($value)
 * @method static Builder<static>|SubjectTranscript whereId($value)
 * @method static Builder<static>|SubjectTranscript whereSubjectId($value)
 * @method static Builder<static>|SubjectTranscript whereTenantId($value)
 * @method static Builder<static>|SubjectTranscript whereTranscriptId($value)
 *
 * @mixin Eloquent
 */
class SubjectTranscript extends Pivot
{
    use BelongsToTenant, HasUuids;

    public $timestamps = false;

    protected $table = 'subject_transcript';

    protected $fillable = [
        'grade',
        'subject_id',
        'transcript_id',
        'tenant_id',
    ];
}
