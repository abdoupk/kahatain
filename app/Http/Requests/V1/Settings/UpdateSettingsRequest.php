<?php

/** @noinspection ALL */

namespace App\Http\Requests\V1\Settings;

use App\Enums\Appearance;
use App\Enums\ColorScheme;
use App\Enums\FontSize;
use App\Enums\Layout;
use App\Enums\Theme;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    /** @noinspection StaticClosureCanBeUsedInspection */
    public function rules(): array
    {
        return [
            'theme' => 'sometimes|in:'.implode(',', array_map(fn ($case) => $case->value, Theme::cases())),
            'appearance' => 'sometimes|in:'.implode(',', array_map(fn ($case) => $case->value, Appearance::cases())),
            'layout' => 'sometimes|in:'.implode(',', array_map(fn ($case) => $case->value, Layout::cases())),
            'color_scheme' => 'sometimes|in:'.implode(',', array_map(fn ($case) => $case->value, ColorScheme::cases())),
            'font_size' => 'sometimes|in:'.implode(',', array_map(fn ($case) => $case->value, FontSize::cases())),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
