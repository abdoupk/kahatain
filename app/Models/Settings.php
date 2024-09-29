<?php

namespace App\Models;

use Database\Factories\SettingsFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 *
 *
 * @property string $id
 * @property string $user_id
 * @property string $locale
 * @property string $theme
 * @property string $color_scheme
 * @property string $layout
 * @property string $appearance
 * @property array|null $notifications
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Tenant $tenant
 * @property-read User $user
 * @method static SettingsFactory factory($count = null, $state = [])
 * @method static Builder|Settings newModelQuery()
 * @method static Builder|Settings newQuery()
 * @method static Builder|Settings query()
 * @method static Builder|Settings whereAppearance($value)
 * @method static Builder|Settings whereColorScheme($value)
 * @method static Builder|Settings whereCreatedAt($value)
 * @method static Builder|Settings whereId($value)
 * @method static Builder|Settings whereLayout($value)
 * @method static Builder|Settings whereLocale($value)
 * @method static Builder|Settings whereNotifications($value)
 * @method static Builder|Settings whereTenantId($value)
 * @method static Builder|Settings whereTheme($value)
 * @method static Builder|Settings whereUpdatedAt($value)
 * @method static Builder|Settings whereUserId($value)
 * @mixin Eloquent
 */
class Settings extends Model
{
    use BelongsToTenant, HasFactory, HasUuids;

    protected $fillable = [
        'theme',
        'color_scheme',
        'layout',
        'appearance',
        'user_id',
        'notifications',
        'tenant_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'notifications' => 'json',
        ];
    }
}
