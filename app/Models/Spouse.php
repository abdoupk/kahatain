<?php

namespace App\Models;

use Database\Factories\SpouseFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 *
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property Carbon $birth_date
 * @property Carbon $death_date
 * @property string $function
 * @property float|null $income
 * @property string $family_id
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Tenant $tenant
 * @method static SpouseFactory factory($count = null, $state = [])
 * @method static Builder|Spouse newModelQuery()
 * @method static Builder|Spouse newQuery()
 * @method static Builder|Spouse query()
 * @method static Builder|Spouse whereBirthDate($value)
 * @method static Builder|Spouse whereCreatedAt($value)
 * @method static Builder|Spouse whereDeathDate($value)
 * @method static Builder|Spouse whereFamilyId($value)
 * @method static Builder|Spouse whereFirstName($value)
 * @method static Builder|Spouse whereFunction($value)
 * @method static Builder|Spouse whereId($value)
 * @method static Builder|Spouse whereIncome($value)
 * @method static Builder|Spouse whereLastName($value)
 * @method static Builder|Spouse whereTenantId($value)
 * @method static Builder|Spouse whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Spouse extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'death_date',
        'function',
        'income',
        'family_id',
    ];

    public function getName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'death_date' => 'date',
        ];
    }
}
