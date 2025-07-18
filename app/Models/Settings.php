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
 * @property string $id
 * @property string $user_id
 * @property string $locale
 * @property string $theme
 * @property string $color_scheme
 * @property string $layout
 * @property string $appearance
 * @property string $font_size
 * @property array<array-key, mixed>|null $notifications
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Tenant $tenant
 * @property-read User $user
 *
 * @method static SettingsFactory factory($count = null, $state = [])
 * @method static Builder<static>|Settings newModelQuery()
 * @method static Builder<static>|Settings newQuery()
 * @method static Builder<static>|Settings query()
 * @method static Builder<static>|Settings whereAppearance($value)
 * @method static Builder<static>|Settings whereColorScheme($value)
 * @method static Builder<static>|Settings whereCreatedAt($value)
 * @method static Builder<static>|Settings whereFontSize($value)
 * @method static Builder<static>|Settings whereId($value)
 * @method static Builder<static>|Settings whereLayout($value)
 * @method static Builder<static>|Settings whereLocale($value)
 * @method static Builder<static>|Settings whereNotifications($value)
 * @method static Builder<static>|Settings whereTenantId($value)
 * @method static Builder<static>|Settings whereTheme($value)
 * @method static Builder<static>|Settings whereUpdatedAt($value)
 * @method static Builder<static>|Settings whereUserId($value)
 *
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
        'font_size',
        'locale',
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
