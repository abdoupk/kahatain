<?php

namespace App\Models;

use Database\Factories\SecondSponsorFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $degree_of_kinship
 * @property string|null $phone_number
 * @property string|null $address
 * @property float|null $income
 * @property string|null $family_id
 * @property string $tenant_id
 * @property bool $with_family
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Tenant $tenant
 *
 * @method static SecondSponsorFactory factory($count = null, $state = [])
 * @method static Builder<static>|SecondSponsor newModelQuery()
 * @method static Builder<static>|SecondSponsor newQuery()
 * @method static Builder<static>|SecondSponsor onlyTrashed()
 * @method static Builder<static>|SecondSponsor query()
 * @method static Builder<static>|SecondSponsor whereAddress($value)
 * @method static Builder<static>|SecondSponsor whereCreatedAt($value)
 * @method static Builder<static>|SecondSponsor whereDegreeOfKinship($value)
 * @method static Builder<static>|SecondSponsor whereDeletedAt($value)
 * @method static Builder<static>|SecondSponsor whereFamilyId($value)
 * @method static Builder<static>|SecondSponsor whereFirstName($value)
 * @method static Builder<static>|SecondSponsor whereId($value)
 * @method static Builder<static>|SecondSponsor whereIncome($value)
 * @method static Builder<static>|SecondSponsor whereLastName($value)
 * @method static Builder<static>|SecondSponsor wherePhoneNumber($value)
 * @method static Builder<static>|SecondSponsor whereTenantId($value)
 * @method static Builder<static>|SecondSponsor whereUpdatedAt($value)
 * @method static Builder<static>|SecondSponsor whereWithFamily($value)
 * @method static Builder<static>|SecondSponsor withTrashed()
 * @method static Builder<static>|SecondSponsor withoutTrashed()
 *
 * @mixin Eloquent
 */
class SecondSponsor extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'degree_of_kinship',
        'phone_number',
        'address',
        'income',
        'with_family',
        'family_id',
        'tenant_id',
    ];

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
