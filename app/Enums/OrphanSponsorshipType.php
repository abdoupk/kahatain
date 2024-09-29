<?php

namespace App\Enums;

enum OrphanSponsorshipType
{
    case SCHOOL_BAG;
    case PRIVATE_LESSONS;
    case EID_SUIT;
    case SUMMER_CAMP;
    case COLLEGE_TRIPS;
    case FELLOWSHIP;
    case GUARANTEED_MEDICAL;

    public function label(): string
    {
        return match ($this) {
            self::SCHOOL_BAG => 'school_bag',
            self::PRIVATE_LESSONS => 'private_lessons',
            self::EID_SUIT => 'eid_suit',
            self::SUMMER_CAMP => 'summer_camp',
            self::COLLEGE_TRIPS => 'college_trips',
            self::FELLOWSHIP => 'fellowship',
            self::GUARANTEED_MEDICAL => 'guaranteed_medical',
        };
    }

    public function valueType(): string
    {
        return match ($this) {
            self::SCHOOL_BAG,
            self::PRIVATE_LESSONS,
            self::EID_SUIT,
            self::SUMMER_CAMP,
            self::COLLEGE_TRIPS,
            self::FELLOWSHIP,
            self::GUARANTEED_MEDICAL => 'checkbox',
        };
    }
}
