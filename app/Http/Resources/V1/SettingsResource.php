<?php

namespace App\Http\Resources\V1;

use App\Enums\Appearance;
use App\Enums\ColorScheme;
use App\Enums\Layout;
use App\Enums\Theme;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $theme
 * @property string $layout
 * @property string $color_scheme
 * @property string $appearance
 * @property string $id
 */
class SettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? null,
            'layout' => Layout::tryFrom($this->layout)->value ?? 'side_menu',
            'theme' => Theme::tryFrom($this->theme)->value ?? 'enigma',
            'color_scheme' => ColorScheme::tryFrom($this->color_scheme)->value ?? 'theme_1',
            'appearance' => Appearance::tryFrom($this->appearance)->value ?? 'light',
        ];
    }
}
