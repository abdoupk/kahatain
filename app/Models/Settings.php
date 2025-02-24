<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

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
