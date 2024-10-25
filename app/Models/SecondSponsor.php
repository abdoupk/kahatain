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
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Tenant $tenant
 *
 * @method static SecondSponsorFactory factory($count = null, $state = [])
 * @method static Builder|SecondSponsor newModelQuery()
 * @method static Builder|SecondSponsor newQuery()
 * @method static Builder|SecondSponsor onlyTrashed()
 * @method static Builder|SecondSponsor query()
 * @method static Builder|SecondSponsor whereAddress($value)
 * @method static Builder|SecondSponsor whereCreatedAt($value)
 * @method static Builder|SecondSponsor whereDegreeOfKinship($value)
 * @method static Builder|SecondSponsor whereDeletedAt($value)
 * @method static Builder|SecondSponsor whereFamilyId($value)
 * @method static Builder|SecondSponsor whereFirstName($value)
 * @method static Builder|SecondSponsor whereId($value)
 * @method static Builder|SecondSponsor whereIncome($value)
 * @method static Builder|SecondSponsor whereLastName($value)
 * @method static Builder|SecondSponsor wherePhoneNumber($value)
 * @method static Builder|SecondSponsor whereTenantId($value)
 * @method static Builder|SecondSponsor whereUpdatedAt($value)
 * @method static Builder|SecondSponsor withTrashed()
 * @method static Builder|SecondSponsor withoutTrashed()
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
    ];

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
