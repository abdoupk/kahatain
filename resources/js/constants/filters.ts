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

// TODO:add dzd icon add death date spouse
export const familiesFilters: ListBoxFilter[] = [
    {
        icon: 'icon-family',
        field: 'id',
        label: 'family',
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
        icon: 'icon-dollar-sign',
        field: 'total_income',
        label: 'total_income',
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
        field: 'family_sponsorships',
        label: 'family_sponsorships',
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
        icon: 'icon-hands-holding-heart',
        field: 'sponsorships',
        label: 'orphan_sponsorships',
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
    }
]

export const eidAlAdhaFilters: ListBoxFilter[] = [
    {
        icon: 'icon-family',
        field: 'family.id',
        label: 'family',
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
        icon: 'icon-branches',
        field: 'family.branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'family.zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'family.orphans_count',
        label: 'orphans_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'family.total_income',
        label: 'total_income',
        type: 'number',
        operators: filterNumberOperators
    }
]

export const schoolEntryFilters: ListBoxFilter[] = [
    {
        icon: 'icon-hands-holding-child',
        field: 'orphan.id',
        label: 'orphan',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-graduation-cap',
        field: 'orphan.academic_achievement.academic_level.id',
        label: 'orphan.academic_level',
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
        icon: 'icon-hashtag',
        field: 'orphan.academic_achievement.last_year_average',
        label: 'general_average',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-hands-holding-heart',
        field: 'sponsorship',
        label: 'orphan_sponsorships',
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
        field: 'orphan.id',
        label: 'orphan',
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
        icon: 'icon-hands-holding-heart',
        field: 'sponsorship',
        label: 'orphan_sponsorships',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-gender',
        field: 'orphan.gender',
        label: 'gender',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-shoes',
        field: 'orphan.shoes_size',
        label: 'shoes_size',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-pants',
        field: 'orphan.pants_size',
        label: 'pants_size',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-shirt-long-sleeve',
        field: 'orphan.shirt_size',
        label: 'shirt_size',
        type: 'object',
        operators: filterObjectOperators
    }
]

export const ramadanBasketFilters: ListBoxFilter[] = [
    {
        icon: 'icon-family',
        field: 'family.id',
        label: 'family',
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
        icon: 'icon-branches',
        field: 'family.branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'family.zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'family.orphans_count',
        label: 'orphans_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'family.total_income',
        label: 'total_income',
        type: 'number',
        operators: filterNumberOperators
    }
]

export const monthlySponsorshipFilters: ListBoxFilter[] = [
    {
        icon: 'icon-family',
        field: 'family.id',
        label: 'family',
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
        icon: 'icon-branches',
        field: 'family.branch.id',
        label: 'branch',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-map-location-dot',
        field: 'family.zone.id',
        label: 'zone',
        type: 'object',
        operators: filterObjectOperators
    },
    {
        icon: 'icon-children',
        field: 'family.orphans_count',
        label: 'orphans_count',
        type: 'number',
        operators: filterNumberOperators
    },
    {
        icon: 'icon-dollar-sign',
        field: 'family.total_income',
        label: 'total_income',
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
