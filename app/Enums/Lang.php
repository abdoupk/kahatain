<?php

namespace App\Enums;

enum Lang: string
{
    case EN = 'en';
    case AR = 'ar';
    case FR = 'fr';

    public function label(): string
    {
        return match ($this) {
            self::AR => 'العربية',
            self::FR => 'Français',
            self::EN => 'English',
        };
    }

    public function flag(): string
    {
        return match ($this) {
            self::AR => 'Flag_of_Algeria.svg',
            self::FR => 'Flag_of_France.svg',
            self::EN => 'Flag_of_the_United_States.svg',
        };
    }

    public function direction(): string
    {
        return match ($this) {
            self::AR => 'rtl',
            self::FR, self::EN => 'ltr',
        };
    }
}
