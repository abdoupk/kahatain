<?php

const LIMIT = 5000;

const DONATION_SPECIFICATION = ['drilling_wells', 'monthly_sponsorship',
    'eid_el_adha', 'eid_el_fitr', 'other', 'school_entry', 'analysis',
    'therapy', 'ramadan_basket',
];

const FILTER_RAMADAN_BASKET = 'AND ramadan_basket != false AND ramadan_basket IS NOT NULL';

const FILTER_EID_SUIT = 'AND eid_suit = true AND eid_suit IS NOT NULL';

const FILTER_EID_AL_ADHA = 'AND eid_al_adha != false AND eid_al_adha IS NOT NULL';

const CALCULATION = [
    'weights' => [
        'sponsor' => [
            'other' => 1,
            'widow' => 1,
            'widower' => 0.75,
            'mother_of_a_supported_childhood' => 0.75,
            'widowers_wife' => 0.75,
            'widows_husband' => 0,
        ],
        'orphans' => [
            'lt_18' => [
                'outside_academic_season' => [
                    'baby' => 1,
                    'below_school_age' => 1,
                    'elementary_school' => 1,
                    'middle_school' => 1,
                    'high_school' => 1,
                    'dismissed' => 1,
                    'professionals' => 1,
                ],
                'during_academic_season' => [
                    'baby' => 1,
                    'below_school_age' => 1,
                    'elementary_school' => 1.25,
                    'middle_school' => 1.5,
                    'high_school' => 1.75,
                    'professionals' => 1,
                    'dismissed' => 1,
                ],
            ],
            'male_gt_18' => [
                'college_boy' => 1,
                'professional_boy' => 1,
                'unemployed' => 1,
                'worker_with_family' => 1,
                'worker_outside_family' => 0,
                'married_with_family' => 1,
                'married_outside_family' => 0,
            ],
            'female_gt_18' => [
                'college_girl' => 1,
                'professional_girl' => 1,
                'at_home_with_no_income' => 1,
                'at_home_with_income' => 1,
                'single_female_employee' => 1,
                'married' => 0,
                'divorced' => 0,
            ],
        ],
        'handicapped' => 1,
    ],
    'percentage_of_contribution' => [
        'sponsor' => [
            'other' => 100,
            'widow' => 100,
            'widower' => 100,
            'mother_of_a_supported_childhood' => 100,
            'widowers_wife' => 100,
            'widows_husband' => 100,
        ],
        'orphans' => [
            'male_gt_18' => [
                'college_boy' => 30,
                'worker_with_family' => 40,
                'worker_outside_family' => 30,
                'married_with_family' => 100,
                'married_outside_family' => 10,
            ],
            'female_gt_18' => [
                'college_girl' => 20,
                'professional_girl' => 25,
                'at_home_with_income' => 30,
                'single_female_employee' => 40,
                'married' => 30,
                'divorced' => 100,
            ],
        ],
    ],
    'unemployed_contribution' => [
        'sponsor' => [
            'other' => 0.00,
            'widow' => 0.00,
            'widower' => 0.00,
            'mother_of_a_supported_childhood' => 0.00,
            'widowers_wife' => 0.00,
            'widows_husband' => 15000.00,
        ],
        'orphans' => [
            'male_gt_18' => [
                'professional_boy' => 6000.00,
                'unemployed' => 10000.00,
                'married_with_family' => 15000.00,
            ],
            'female_gt_18' => [
                'at_home_with_no_income' => 3000.00,
            ],
        ],
    ],
    'handicapped_contribution' => [
        'income' => 10000.00,
        'contribution' => 10000.00,
    ],
];
