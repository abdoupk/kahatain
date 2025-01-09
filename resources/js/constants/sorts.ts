import { $t, getLocale } from '@/utils/i18n'

export const memberSorts = [
    {
        value: 'name',
        label: 'sorts.member'
    },
    {
        value: 'email',
        label: 'validation.attributes.email'
    }
]

export const roleSorts = [
    {
        value: 'name',
        label: 'the_role'
    },
    {
        value: 'permissions_count',
        label: 'permissions_count'
    },
    {
        value: 'members_count',
        label: 'members_count'
    },
    {
        value: 'created_at',
        label: 'filters.created_at'
    }
]

export const branchesSorts = [
    {
        value: 'name',
        label: 'the_branch'
    },
    {
        value: 'president.name',
        label: 'branch_president'
    },
    {
        value: 'members_count',
        label: 'members_count'
    },
    {
        value: `city.${getLocale()}_name`,
        label: 'location'
    },
    {
        value: 'families_count',
        label: 'families_count'
    },
    {
        value: 'created_at',
        label: 'filters.created_at'
    }
]

export const committeesSorts = [
    {
        value: 'name',
        label: 'the_committee'
    },
    {
        value: 'members_count',
        label: 'members_count'
    },
    {
        value: 'created_at',
        label: 'filters.created_at'
    }
]

export const zonesSorts = [
    {
        value: 'name',
        label: 'the_zone'
    },
    {
        value: 'families_count',
        label: 'families_count'
    },
    {
        value: 'members_count',
        label: 'members_count'
    },
    {
        value: 'created_at',
        label: 'filters.created_at'
    }
]

export const familiesSorts = [
    {
        value: 'name',
        label: 'the_sponsor'
    },
    {
        value: 'start_date',
        label: 'filters.starting_sponsorship_date'
    },
    {
        value: 'file_number',
        label: 'file_number'
    },
    {
        value: 'orphans_count',
        label: 'orphans_count'
    }
]

export const orphansSorts = [
    {
        value: 'name',
        label: 'the_orphan'
    },
    {
        value: `family_status.${getLocale()}`,
        label: 'family_status'
    },
    {
        value: 'academic_level.i_id',
        label: 'academic_level'
    },
    {
        value: 'birth_date',
        label: 'filters.birth_date'
    }
]

export const sponsorsSorts = [
    {
        value: 'name',
        label: 'the_sponsor'
    },
    {
        value: 'health_status',
        label: 'health_status'
    },
    {
        value: 'academic_level.i_id',
        label: 'academic_level'
    },
    {
        value: 'birth_date',
        label: 'filters.birth_date'
    }
]

export const monthlySponsorshipSorts = [
    {
        value: 'sponsor.name',
        label: 'the_sponsor'
    },
    {
        value: 'orphans_count',
        label: 'orphans_count'
    },
    {
        value: 'total_income',
        label: 'filters.total_income'
    },
    {
        value: 'income_rate',
        label: 'income_rate'
    },
    {
        value: 'difference_before_monthly_sponsorship',
        label: 'monthly_sponsorship.difference_before_monthly_sponsorship'
    },
    {
        value: 'difference_after_monthly_sponsorship',
        label: 'monthly_sponsorship.difference_after_monthly_sponsorship'
    },
    {
        value: 'basket_from_association',
        label: 'filters.basket_from_association'
    },
    {
        value: 'amount_from_association',
        label: 'filters.amount_from_association'
    },
    {
        value: 'basket_from_benefactor',
        label: 'filters.basket_from_benefactor'
    },
    {
        value: 'amount_from_benefactor',
        label: 'filters.amount_from_benefactor'
    },
    {
        value: 'difference_after_monthly_sponsorship',
        label: 'filters.difference_after_monthly_sponsorship'
    },
    {
        value: 'monthly_sponsorship_rate',
        label: 'filters.monthly_sponsorship_rate'
    },
    {
        value: 'address.zone.name',
        label: 'validation.attributes.address'
    },
    {
        value: 'branch.name',
        label: 'the_branch'
    }
]
export const eidAlAdhaSorts = [
    {
        value: 'sponsor.name',
        label: 'the_sponsor'
    },
    {
        value: 'address.zone.name',
        label: 'validation.attributes.address'
    },
    {
        value: 'branch.name',
        label: 'the_branch'
    },
    {
        value: 'orphans_count',
        label: 'orphans_count'
    },
    {
        value: 'income_rate',
        label: 'income_rate'
    },
    {
        value: 'total_income',
        label: 'filters.total_income'
    }
]

export const zakatSorts = [
    {
        value: 'sponsor.name',
        label: 'the_sponsor'
    },
    {
        value: 'address.zone.name',
        label: 'validation.attributes.address'
    },
    {
        value: 'branch.name',
        label: 'the_branch'
    },
    {
        value: 'orphans_count',
        label: 'orphans_count'
    },
    {
        value: 'aggregate_zakat_benefit',
        label: 'aggregate_zakat_benefit'
    },
    {
        value: 'income_rate',
        label: 'income_rate'
    },
    {
        value: 'total_income',
        label: 'filters.total_income'
    }
]
export const schoolEntrySorts = [
    {
        value: 'name',
        label: 'the_child'
    },
    {
        value: 'academic_level.i_id',
        label: 'academic_level'
    },
    {
        value: 'academic_average',
        label: 'general_average'
    },
    {
        value: 'sponsor.name',
        label: 'the_sponsor'
    },
    {
        value: 'income_rate',
        label: 'income_rate'
    }
]

export const eidSuitSorts = [
    {
        value: 'name',
        label: 'the_child'
    },
    {
        value: 'pants_size',
        label: 'pants_size'
    },
    {
        value: 'shoes_size',
        label: 'shoes_size'
    },
    {
        value: 'shirt_size',
        label: 'shirt_size'
    },
    {
        value: 'birth_date',
        label: 'age'
    },
    {
        value: 'income_rate',
        label: 'income_rate'
    },
    {
        value: 'sponsor.name',
        label: 'the_sponsor'
    }
]
export const ramadanBasketSorts = [
    {
        value: 'sponsor.name',
        label: 'the_sponsor'
    },
    {
        value: 'address.zone.name',
        label: 'validation.attributes.address'
    },
    {
        value: 'branch.name',
        label: 'the_branch'
    },
    {
        value: 'orphans_count',
        label: 'orphans_count'
    },
    {
        value: 'income_rate',
        label: 'income_rate'
    },
    {
        value: 'total_income',
        label: 'filters.total_income'
    },
    {
        value: 'basket_from_benefactor',
        label: 'filters.basket_from_benefactor'
    },
    {
        value: 'amount_from_benefactor',
        label: 'filters.amount_from_benefactor'
    },
    {
        value: 'ramadan_sponsorship_difference',
        label: 'monthly_sponsorship.difference'
    },
    {
        value: 'ramadan_basket_category',
        label: 'ramadan_basket_category'
    }
]

export const babiesMilkAndDiapersSorts = [
    {
        value: 'name',
        label: 'the_child'
    },
    {
        value: 'baby_milk_quantity',
        label: 'baby_milk_quantity'
    },
    {
        value: 'diapers_quantity',
        label: 'diapers_quantity'
    },
    {
        value: 'birth_date',
        label: 'age'
    },
    {
        value: 'sponsor.name',
        label: 'the_sponsor'
    }
]

export const meatDistributionSorts = [
    {
        value: 'sponsor.name',
        label: 'the_sponsor'
    },
    {
        value: 'aggregate_white_meat_benefit',
        label: 'aggregate_white_meat_benefit'
    },
    {
        value: 'aggregate_red_meat_benefit',
        label: 'aggregate_red_meat_benefit'
    },
    {
        value: 'address.zone.name',
        label: 'validation.attributes.address'
    },
    {
        value: 'branch.name',
        label: 'the_branch'
    },
    {
        value: 'orphans_count',
        label: 'orphans_count'
    },
    {
        value: 'income_rate',
        label: 'income_rate'
    },
    {
        value: 'total_income',
        label: 'filters.total_income'
    }
]

export const benefactorsSorts = [
    {
        value: 'name',
        label: 'the_benefactor'
    },
    {
        value: 'sponsorships_count',
        label: 'sponsorships_count'
    },
    {
        value: 'created_at',
        label: 'added_at'
    }
]

export const financesSorts = [
    {
        value: 'creator.name',
        label: 'receiving_member'
    },
    {
        value: 'amount',
        label: 'the_amount'
    },
    {
        value: 'created_at',
        label: 'added_at'
    },
    {
        value: `specification.${getLocale()}`,
        label: 'filters.finance_specification'
    },
    {
        value: 'date',
        label: 'the date'
    }
]

export const needsSorts = [
    {
        value: 'name',
        label: 'the_need'
    },
    {
        value: 'members_count',
        label: 'members_count'
    },
    {
        value: 'created_at',
        label: 'filters.created_at'
    }
]

export const transcriptsSorts = [
    {
        value: 'name',
        label: 'the_child'
    },
    {
        value: 'academic_level.i_id',
        label: 'academic_level'
    },
    {
        value: 'birth_date',
        label: 'filters.birth_date'
    },
    {
        value: 'institution.name',
        label: 'validation.attributes.institution'
    },
    {
        value: 'academic_average',
        label: 'general_average'
    },
    {
        value: 'sponsor.name',
        label: 'the_sponsor'
    }
]
export const inventorySorts = [
    {
        value: 'name',
        label: 'the_item'
    },
    {
        value: 'qty',
        label: 'validation.attributes.amount'
    },
    {
        value: 'created_at',
        label: 'added_at'
    }
]
export const privateSchoolsSorts = [
    {
        value: 'name',
        label: 'the_school'
    },
    {
        value: 'quota',
        label: 'quota_total'
    },
    {
        value: 'created_at',
        label: 'added_at'
    }
]
