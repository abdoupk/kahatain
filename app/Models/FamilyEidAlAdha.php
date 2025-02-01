<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string|null $status
 * @property string $family_id
 * @property string $updated_by
 * @property string $tenant_id
 * @property string|null $note
 * @property bool $validated
 * @property int $year
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Family $family
 * @property-read Tenant $tenant
 *
 * @method static Builder<static>|FamilyEidAlAdha newModelQuery()
 * @method static Builder<static>|FamilyEidAlAdha newQuery()
 * @method static Builder<static>|FamilyEidAlAdha query()
 * @method static Builder<static>|FamilyEidAlAdha whereCreatedAt($value)
 * @method static Builder<static>|FamilyEidAlAdha whereFamilyId($value)
 * @method static Builder<static>|FamilyEidAlAdha whereId($value)
 * @method static Builder<static>|FamilyEidAlAdha whereNote($value)
 * @method static Builder<static>|FamilyEidAlAdha whereStatus($value)
 * @method static Builder<static>|FamilyEidAlAdha whereTenantId($value)
 * @method static Builder<static>|FamilyEidAlAdha whereUpdatedAt($value)
 * @method static Builder<static>|FamilyEidAlAdha whereUpdatedBy($value)
 * @method static Builder<static>|FamilyEidAlAdha whereValidated($value)
 * @method static Builder<static>|FamilyEidAlAdha whereYear($value)
 *
 * @mixin Eloquent
 */
class FamilyEidAlAdha extends Model
{
    use BelongsToTenant, HasUuids;

    protected $fillable = [
        'family_id',
        'tenant_id',
        'status',
        'updated_by',
        'year',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
