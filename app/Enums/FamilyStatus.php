<?php

namespace App\Enums;

enum FamilyStatus: string
{
    case SECOND_SPONSOR_OUTSIDE_FAMILY = 'second_sponsor_outside_family';
    case SECOND_SPONSOR_WITH_FAMILY = 'second_sponsor_with_family';
    case COLLEGE_GIRL = 'college_girl';

    case PROFESSIONALS = 'professionals';
    case PROFESSIONAL_GIRL = 'professional_girl';
    case AT_HOME_WITH_NO_INCOME = 'at_home_with_no_income';
    case AT_HOME_WITH_INCOME = 'at_home_with_income';
    case SINGLE_FEMALE_EMPLOYEE = 'single_female_employee';
    case MARRIED = 'married';
    case DIVORCED_WITH_FAMILY = 'divorced_with_family';
    case DIVORCED_OUTSIDE_FAMILY = 'divorced_outside_family';
    case COLLEGE_BOY = 'college_boy';
    case PROFESSIONAL_BOY = 'professional_boy';
    case UNEMPLOYED = 'unemployed';
    case WORKER_WITH_FAMILY = 'worker_with_family';
    case WORKER_OUTSIDE_FAMILY = 'worker_outside_family';
    case MARRIED_WITH_FAMILY = 'married_with_family';
    case MARRIED_OUTSIDE_FAMILY = 'married_outside_family';

}
