<?php

namespace App\Enums;

enum DonationSpecification: string
{
    case DRILLING_WELLS = 'drilling_wells';

    case MONTHLY_SPONSORSHIP = 'monthly_sponsorship';

    case EID_EL_ADHA = 'eid_el_adha';

    case EID_EL_FITR = 'eid_el_fitr';

    case ZAKAT_EL_FITR = 'zakat_el_fitr';

    case ZAKAT = 'zakat';

    case OTHER = 'other';

    case SCHOOL_ENTRY = 'school_entry';

    case ANALYSIS = 'analysis';

    case THERAPY = 'therapy';

    case RAMADAN_BASKET = 'ramadan_basket';
}
