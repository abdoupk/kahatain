<?php

namespace App\Models;

use Database\Factories\SponsorshipFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property string $id
 * @property float $amount
 * @property string $benefactor_id
 * @property string $recipientable_type
 * @property string $recipientable_id
 * @property string $sponsorship_type
 * @property array|null $shop
 * @property string $created_by
 * @property string|null $deleted_by
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Benefactor|null $benefactor
 * @property-read User|null $creator
 * @property-read Model|Eloquent $recipientable
 * @property-read Tenant|null $tenant
 *
 * @method static SponsorshipFactory factory($count = null, $state = [])
 * @method static Builder<static>|Sponsorship newModelQuery()
 * @method static Builder<static>|Sponsorship newQuery()
 * @method static Builder<static>|Sponsorship onlyTrashed()
 * @method static Builder<static>|Sponsorship query()
 * @method static Builder<static>|Sponsorship whereAmount($value)
 * @method static Builder<static>|Sponsorship whereBenefactorId($value)
 * @method static Builder<static>|Sponsorship whereCreatedAt($value)
 * @method static Builder<static>|Sponsorship whereCreatedBy($value)
 * @method static Builder<static>|Sponsorship whereDeletedAt($value)
 * @method static Builder<static>|Sponsorship whereDeletedBy($value)
 * @method static Builder<static>|Sponsorship whereId($value)
 * @method static Builder<static>|Sponsorship whereRecipientableId($value)
 * @method static Builder<static>|Sponsorship whereRecipientableType($value)
 * @method static Builder<static>|Sponsorship whereShop($value)
 * @method static Builder<static>|Sponsorship whereSponsorshipType($value)
 * @method static Builder<static>|Sponsorship whereTenantId($value)
 * @method static Builder<static>|Sponsorship whereUpdatedAt($value)
 * @method static Builder<static>|Sponsorship withTrashed()
 * @method static Builder<static>|Sponsorship withoutTrashed()
 *
 * @mixin Eloquent
 */
class Sponsorship extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable, SoftDeletes;

    protected $fillable = [
        'amount',
        'benefactor_id',
        'recipientable_id',
        'recipientable_type',
        'sponsorship_type',
        'shop',
        'created_by',
        'deleted_by',
        'tenant_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model): void {
            if (auth()->id()) {
                $model->created_by = auth()->id();
            }
        });

        static::softDeleted(function ($model): void {
            if (auth()->id()) {
                $model->deleted_by = auth()->id();

                $model->save();
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function benefactor(): BelongsTo
    {
        return $this->belongsTo(Benefactor::class, 'benefactor_id');
    }

    public function recipientable(): BelongsTo
    {
        return $this->MorphTo();
    }

    protected function casts(): array
    {
        return [
            'shop' => 'array',
        ];
    }
}
