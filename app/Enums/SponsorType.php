<?php

namespace App\Enums;

enum SponsorType: string
{
    case WIDOWER = 'widower';

    case WIDOW = 'widow';

    case WIDOWS_HUSBAND = 'widows_husband';

    case WIDOWERS_WIFE = 'widowers_wife';
    case MOTHER_OF_A_SUPPORTED_CHILDHOOD = 'mother_of_a_supported_childhood';

    case OTHER = 'other';
}
