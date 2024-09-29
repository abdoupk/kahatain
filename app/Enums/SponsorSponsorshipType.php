<?php

namespace App\Enums;

enum SponsorSponsorshipType
{
    case GuaranteedMedical;
    case SupportTheDraft;
    case LiteracyClasses;
    case DirectSponsorship;

    public function label(): string
    {
        return match ($this) {
            self::GuaranteedMedical => 'guaranteed_medical',
            self::SupportTheDraft => 'support_the_draft',
            self::LiteracyClasses => 'literacy_classes',
            self::DirectSponsorship => 'direct_sponsorship',
        };
    }

    public function valueType(): string
    {
        return match ($this) {
            self::GuaranteedMedical, self::SupportTheDraft => 'text',
            self::LiteracyClasses => 'checkbox',
            self::DirectSponsorship => 'number',
        };
    }
}
