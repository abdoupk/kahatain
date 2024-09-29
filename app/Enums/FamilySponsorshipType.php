<?php

namespace App\Enums;

enum FamilySponsorshipType
{
    case RAMADAN_BASKET;
    case MONTHLY_EXPENSE;
    case EID_AL_ADHA;
    case ZAKAT;
    case HOUSING_ASSISTANCE;

    public function label(): string
    {
        return match ($this) {
            self::RAMADAN_BASKET => 'ramadan_basket',
            self::MONTHLY_EXPENSE => 'monthly_expense',
            self::EID_AL_ADHA => 'eid_al_adha',
            self::ZAKAT => 'zakat',
            self::HOUSING_ASSISTANCE => 'housing_assistance',
        };
    }

    public function valueType(): string
    {
        return match ($this) {
            self::RAMADAN_BASKET, self::EID_AL_ADHA, self::ZAKAT, self::HOUSING_ASSISTANCE => 'checkbox',
            self::MONTHLY_EXPENSE => 'number',
        };
    }
}
