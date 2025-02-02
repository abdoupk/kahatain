import type { ListBoxFilter, ListBoxOperator } from '@/types/types'

const filterObjectOperators: Array<ListBoxOperator> = [
    {
        label: 'filters.is',
        value: '='
    },
    {
        label: 'filters.is_not',
        value: '!='
    }
]

const filterDateOperators: Array<ListBoxOperator> = [
    {
        label: 'filters.before',
        value: '<'
    },
    {
        label: 'filters.after',
        value: '>'
    },
    {
        label: 'filters.on',
        value: '='
    },
    {
        label: 'filters.is_not_on',
        value: '!='
    },
    {
        label: 'filters.is_in_the_past',
        value: '<='
    },
    {
        label: 'filters.is_in_the_future',
        value: '>='
    }
]

const filterNumberOperators: Array<ListBoxOperator> = [
    {
        label: 'filters.equal_to',
        value: '='
    },
    {
        label: 'filters.not_equal_to',
        value: '!='
    },
    {
        label: 'filters.is_greater_than',
        value: '>'
    },
    {
        label: 'filters.is_less_than',
        value: '<'
    },
    {
        label: 'filters.is_greater_than_or_equal_to',
        value: '>='
    },
    {
        label: 'filters.is_less_than_or_equal_to',
        value: '<='
    }
]

const filterStringOperators: Array<ListBoxOperator> = [
    {
        label: 'filters.equal_to',
        value: '='
    },
    {
        label: 'filters.not_equal_to',
        value: '!='
    }
]

const filterCategoryOperators: Array<ListBoxOperator> = [
    {
        label: 'filters.is',
        value: 'IN'
    },
    {
        label: 'filters.is_not',
        value: 'NOT IN'
    }
]

const filterBooleanOperators: Array<ListBoxOperator> = [
    {
        label: 'filters.equal_to',
        value: '='
    }
]

// TODO:add dzd icon add death date spouse
export const familiesFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-branches',
        field: 'branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'address.zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'orphans_count',
        label: 'orphans_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-briefcase',
        field: 'spouse.function',
        label: 'spouse.function',
        type: 'string',
        operators: filterStringOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-graduation-cap',
        field: 'sponsor.academic_level_id',
        label: 'sponsor_academic_level',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-calendar',
        field: 'start_date',
        label: 'starting_sponsorship_date',
        type: 'date',
        operators: filterDateOperators
    },
    {
        icon: 'icon-hands-holding-heart',
        field: 'furnishings',
        label: 'furnishings',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const sponsorsFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'orphans_count',
        label: 'children_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'income',
        label: 'income',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'family.income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-graduation-cap',
        field: 'academic_level_id',
        label: 'sponsor.academic_level',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-calendar',
        field: 'birth_date',
        label: 'birth_date',
        type: 'date',
        operators: filterDateOperators
    },
    {
        icon: 'icon-handshake-angle',
        field: 'sponsorships',
        label: 'sponsor_sponsorships',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-stethoscope',
        field: 'health_status',
        label: 'health_status',
        type: 'string',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-hands-holding-heart',
        field: 'sponsor_type',
        label: 'sponsor_type',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-gender',
        field: 'gender',
        label: 'gender',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-briefcase',
        field: 'function',
        label: 'function',
        type: 'string',
        operators: filterStringOperators
    }
]

export const orphansFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'id',
        label: 'orphan',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'income',
        label: 'income',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'family.income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-graduation-cap',
        field: 'academic_level.id',
        label: 'orphan.academic_level',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-calendar',
        field: 'birth_date',
        label: 'birth_date',
        type: 'date',
        operators: filterDateOperators
    },
    {
        icon: 'icon-stethoscope',
        field: 'health_status',
        label: 'health_status',
        type: 'string',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-people-roof',
        field: 'family_status',
        label: 'family_status',
        type: 'string',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-gender',
        field: 'gender',
        label: 'gender',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-shoes',
        field: 'shoes_size',
        label: 'shoes_size',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-pants',
        field: 'pants_size',
        label: 'pants_size',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-shirt-long-sleeve',
        field: 'shirt_size',
        label: 'shirt_size',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-graduation-cap',
        field: 'speciality.speciality',
        label: 'speciality',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const eidAlAdhaFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-branches',
        field: 'branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'address.zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'orphans_count',
        label: 'orphans_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-check-circle',
        field: 'eid_al_adha_status',
        label: 'status',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const zakatFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-branches',
        field: 'branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'address.zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'orphans_count',
        label: 'orphans_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'aggregate_zakat_benefit',
        label: 'aggregate_zakat_benefit',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    }
]

export const meatDistributionFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-branches',
        field: 'branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'address.zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'orphans_count',
        label: 'orphans_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'aggregate_red_meat_benefit',
        label: 'aggregate_red_meat_benefit',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'aggregate_white_meat_benefit',
        label: 'aggregate_white_meat_benefit',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    }
]

export const schoolEntryFilters: ListBoxFilter[] = [
    {
        icon: 'icon-children',
        field: 'id',
        label: 'orphan',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'family.income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-graduation-cap',
        field: 'last_academic_year_achievement.academic_level.id',
        label: 'orphan.academic_level',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-calendar',
        field: 'birth_date',
        label: 'birth_date',
        type: 'date',
        operators: filterDateOperators
    },
    {
        icon: 'icon-graduation-cap',
        field: 'academic_average',
        label: 'academic_average',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-stethoscope',
        field: 'health_status',
        label: 'health_status',
        type: 'string',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-gender',
        field: 'gender',
        label: 'gender',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const eidSuitsFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'id',
        label: 'orphan',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'family.income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-calendar',
        field: 'birth_date',
        label: 'birth_date',
        type: 'date',
        operators: filterDateOperators
    },
    {
        icon: 'icon-gender',
        field: 'gender',
        label: 'gender',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-shoes',
        field: 'shoes_size',
        label: 'shoes_size',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-pants',
        field: 'pants_size',
        label: 'pants_size',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-shirt-long-sleeve',
        field: 'shirt_size',
        label: 'shirt_size',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const ramadanBasketFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-branches',
        field: 'branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'address.zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'orphans_count',
        label: 'orphans_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'amount_from_benefactor',
        label: 'amount_from_benefactor',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'basket_from_benefactor',
        label: 'basket_from_benefactor',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'difference_before_ramadan_sponsorship',
        label: 'difference_before_ramadan_sponsorship',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-grid',
        field: 'ramadan_basket_category',
        label: 'ramadan_basket_category',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const monthlySponsorshipFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-branches',
        field: 'branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'address.zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'orphans_count',
        label: 'orphans_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'difference_before_monthly_sponsorship',
        label: 'difference_before_monthly_sponsorship',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'difference_after_monthly_sponsorship',
        label: 'difference_after_monthly_sponsorship',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'monthly_sponsorship_rate',
        label: 'monthly_sponsorship_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'amount_from_association',
        label: 'amount_from_association',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'amount_from_benefactor',
        label: 'amount_from_benefactor',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'basket_from_benefactor',
        label: 'basket_from_benefactor',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-basket-shopping',
        field: 'basket_from_association',
        label: 'basket_from_association',
        type: 'boolean',
        operators: filterBooleanOperators
    }
]

export const needsFilters: ListBoxFilter[] = [
    {
        icon: 'icon-branches',
        field: 'branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-user',
        field: 'needable.type',
        label: 'recipient_type',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-check-circle',
        field: 'status',
        label: 'status',
        type: 'object',
        operators: filterObjectOperators
    }
]
// Add diapers icon
export const babiesMilkAndDiapersFilters: ListBoxFilter[] = [
    {
        icon: 'icon-children',
        field: 'orphan.id',
        label: 'orphan',
        type: 'object',
        operators: filterObjectOperators
    },
    // TODO fix this
    {
        icon: 'icon-hashtag',
        field: 'family.income_rate',
        label: 'income_rate',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-calendar',
        field: 'orphan.birth_date',
        label: 'birth_date',
        type: 'date',
        operators: filterDateOperators
    },
    {
        icon: 'icon-bottle-baby',
        field: 'baby_milk_type',
        label: 'baby_milk_type',
        type: 'string',
        operators: filterStringOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'baby_milk_quantity',
        label: 'baby_milk_quantity',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-briefcase',
        field: 'diapers_type',
        label: 'diapers_type',
        type: 'string',
        operators: filterStringOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'diapers_quantity',
        label: 'diapers_quantity',
        type: 'number',
        operators: filterNumberOperators
    }
]

export const zonesFilters: ListBoxFilter[] = [
    {
        icon: 'icon-map-location-dot',
        field: 'id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'families_count',
        label: 'families_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-calendar',
        field: 'created_at',
        label: 'created_at',
        type: 'date',
        operators: filterDateOperators
    }
]

export const branchedFilters: ListBoxFilter[] = [
    {
        icon: 'icon-branches',
        field: 'id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'families_count',
        label: 'families_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-calendar',
        field: 'created_at',
        label: 'created_at',
        type: 'date',
        operators: filterDateOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'city.id',
        label: 'location',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-users-gear',
        field: 'president.id',
        label: 'branch_president',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const benefactorsFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hashtag',
        field: 'sponsorships_count',
        label: 'sponsorships_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-calendar',
        field: 'created_at',
        label: 'created_at',
        type: 'date',
        operators: filterDateOperators
    }
]

export const committeesFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hashtag',
        field: 'members_count',
        label: 'members_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-calendar',
        field: 'created_at',
        label: 'created_at',
        type: 'date',
        operators: filterDateOperators
    }
]

export const membersFilters: ListBoxFilter[] = [
    {
        icon: 'icon-users',
        field: 'committees',
        label: 'committee',
        type: 'string',
        operators: filterCategoryOperators
    },
    {
        icon: 'icon-user-lock',
        field: 'roles',
        label: 'role',
        type: 'string',
        operators: filterCategoryOperators
    },
    {
        icon: 'icon-head-side-gear',
        field: 'competences',
        label: 'competence',
        type: 'string',
        operators: filterCategoryOperators
    },
    {
        icon: 'icon-graduation-cap',
        field: 'academic_level.id',
        label: 'member_academic_level',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-branches',
        field: 'branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-gender',
        field: 'gender',
        label: 'gender',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const financialFilters: ListBoxFilter[] = [
    {
        icon: 'icon-calendar',
        field: 'created_at',
        label: 'created_at',
        type: 'date',
        operators: filterDateOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'abs_amount',
        label: 'amount',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hashtag',
        field: 'specification.en',
        label: 'finance_specification',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'finance_type',
        label: 'finance_type',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-users-gear',
        field: 'receiver.id',
        label: 'receiver',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-users-gear',
        field: 'creator.id',
        label: 'creator',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-calendar',
        field: 'date',
        label: 'date',
        type: 'date',
        operators: filterDateOperators
    }
]

export const collegeStudentsFilters: ListBoxFilter[] = [
    {
        icon: 'icon-graduation-cap',
        field: 'speciality.speciality',
        label: 'speciality',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-school-lock',
        field: 'institution.id',
        label: 'university',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const studentsFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'sponsor.id',
        label: 'sponsor',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'id',
        label: 'orphan',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-branches',
        field: 'branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'address.zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-graduation-cap',
        field: 'academic_average',
        label: 'academic_average',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-graduation-cap',
        field: 'academic_level.id',
        label: 'orphan.academic_level',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-school-lock',
        field: 'institution.id',
        label: 'school',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const traineesOrphansFilters: ListBoxFilter[] = [
    {
        icon: 'icon-school-lock',
        field: 'institution.id',
        label: 'institute',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const lessonsFilters: ListBoxFilter[] = []
