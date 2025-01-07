import { $t, getLocale } from '@/utils/i18n'

export const memberSorts = [
    {
        value: 'name',
        label: $t('sorts.member')
    },
    {
        value: 'email',
        label: $t('validation.attributes.email')
    }
]

export const roleSorts = [
    {
        value: 'name',
        label: $t('the_role')
    },
    {
        value: 'permissions_count',
        label: $t('permissions_count')
    },
    {
        value: 'members_count',
        label: $t('members_count')
    },
    {
        value: 'created_at',
        label: $t('filters.created_at')
    }
]

export const branchesSorts = [
    {
        value: 'name',
        label: $t('the_branch')
    },
    {
        value: 'president.name',
        label: $t('branch_president')
    },
    {
        value: 'members_count',
        label: $t('members_count')
    },
    {
        value: `city.${getLocale()}_name`,
        label: $t('location')
    },
    {
        value: 'families_count',
        label: $t('families_count')
    },
    {
        value: 'created_at',
        label: $t('filters.created_at')
    }
]

export const committeesSorts = [
    {
        value: 'name',
        label: $t('the_committee')
    },
    {
        value: 'members_count',
        label: $t('members_count')
    },
    {
        value: 'created_at',
        label: $t('filters.created_at')
    }
]

export const zonesSorts = [
    {
        value: 'name',
        label: $t('the_zone')
    },
    {
        value: 'families_count',
        label: $t('families_count')
    },
    {
        value: 'members_count',
        label: $t('members_count')
    },
    {
        value: 'created_at',
        label: $t('filters.created_at')
    }
]

export const familiesSorts = [
    {
        value: 'name',
        label: $t('the_sponsor')
    },
    {
        value: 'start_date',
        label: $t('filters.starting_sponsorship_date')
    },
    {
        value: 'file_number',
        label: $t('file_number')
    },
    {
        value: 'orphans_count',
        label: $t('orphans_count')
    }
]

export const orphansSorts = [
    {
        value: 'name',
        label: $t('the_orphan')
    },
    {
        value: `family_status.${getLocale()}`,
        label: $t('family_status')
    },
    {
        value: 'academic_level.i_id',
        label: $t('academic_level')
    },
    {
        value: 'birth_date',
        label: $t('filters.birth_date')
    }
]

export const sponsorsSorts = [
    {
        value: 'name',
        label: $t('the_sponsor')
    },
    {
        value: 'health_status',
        label: $t('health_status')
    },
    {
        value: 'academic_level.i_id',
        label: $t('academic_level')
    },
    {
        value: 'birth_date',
        label: $t('filters.birth_date')
    }
]

export const monthlySponsorshipSorts = [
    {
        value: 'sponsor.name',
        label: $t('the_sponsor')
    },
    {
        value: 'orphans_count',
        label: $t('orphans_count')
    },
    {
        value: 'total_income',
        label: $t('filters.total_income')
    },
    {
        value: 'income_rate',
        label: $t('income_rate')
    },
    {
        value: 'difference_before_monthly_sponsorship',
        label: $t('monthly_sponsorship.difference_before_monthly_sponsorship')
    },
    {
        value: 'difference_after_monthly_sponsorship',
        label: $t('monthly_sponsorship.difference_after_monthly_sponsorship')
    },
    {
        value: 'basket_from_association',
        label: $t('filters.basket_from_association')
    },
    {
        value: 'amount_from_association',
        label: $t('filters.amount_from_association')
    },
    {
        value: 'basket_from_benefactor',
        label: $t('filters.basket_from_benefactor')
    },
    {
        value: 'amount_from_benefactor',
        label: $t('filters.amount_from_benefactor')
    },
    {
        value: 'difference_after_monthly_sponsorship',
        label: $t('filters.difference_after_monthly_sponsorship')
    },
    {
        value: 'monthly_sponsorship_rate',
        label: $t('filters.monthly_sponsorship_rate')
    },
    {
        value: 'address.zone.name',
        label: $t('validation.attributes.address')
    },
    {
        value: 'branch.name',
        label: $t('the_branch')
    }
]
export const eidAlAdhaSorts = [
    {
        value: 'sponsor.name',
        label: $t('the_sponsor')
    },
    {
        value: 'address.zone.name',
        label: $t('validation.attributes.address')
    },
    {
        value: 'branch.name',
        label: $t('the_branch')
    },
    {
        value: 'orphans_count',
        label: $t('orphans_count')
    },
    {
        value: 'income_rate',
        label: $t('income_rate')
    },
    {
        value: 'total_income',
        label: $t('filters.total_income')
    }
]

export const zakatSorts = [
    {
        value: 'sponsor.name',
        label: $t('the_sponsor')
    },
    {
        value: 'address.zone.name',
        label: $t('validation.attributes.address')
    },
    {
        value: 'branch.name',
        label: $t('the_branch')
    },
    {
        value: 'orphans_count',
        label: $t('orphans_count')
    },
    {
        value: 'aggregate_zakat_benefit',
        label: $t('aggregate_zakat_benefit')
    },
    {
        value: 'income_rate',
        label: $t('income_rate')
    },
    {
        value: 'total_income',
        label: $t('filters.total_income')
    }
]
export const schoolEntrySorts = [
    {
        value: 'name',
        label: $t('the_child')
    },
    {
        value: 'academic_level.i_id',
        label: $t('academic_level')
    },
    {
        value: 'academic_average',
        label: $t('general_average')
    },
    {
        value: 'sponsor.name',
        label: $t('the_sponsor')
    },
    {
        value: 'income_rate',
        label: $t('income_rate')
    }
]

export const eidSuitSorts = [
    {
        value: 'name',
        label: $t('the_child')
    },
    {
        value: 'pants_size',
        label: $t('pants_size')
    },
    {
        value: 'shoes_size',
        label: $t('shoes_size')
    },
    {
        value: 'shirt_size',
        label: $t('shirt_size')
    },
    {
        value: 'birth_date',
        label: $t('age')
    },
    {
        value: 'income_rate',
        label: $t('income_rate')
    },
    {
        value: 'sponsor.name',
        label: $t('the_sponsor')
    }
]
export const ramadanBasketSorts = [
    {
        value: 'sponsor.name',
        label: $t('the_sponsor')
    },
    {
        value: 'address.zone.name',
        label: $t('validation.attributes.address')
    },
    {
        value: 'branch.name',
        label: $t('the_branch')
    },
    {
        value: 'orphans_count',
        label: $t('orphans_count')
    },
    {
        value: 'income_rate',
        label: $t('income_rate')
    },
    {
        value: 'total_income',
        label: $t('filters.total_income')
    },
    {
        value: 'basket_from_benefactor',
        label: $t('filters.basket_from_benefactor')
    },
    {
        value: 'amount_from_benefactor',
        label: $t('filters.amount_from_benefactor')
    },
    {
        value: 'ramadan_sponsorship_difference',
        label: $t('monthly_sponsorship.difference')
    },
    {
        value: 'ramadan_basket_category',
        label: $t('ramadan_basket_category')
    }
]

export const babiesMilkAndDiapersSorts = [
    {
        value: 'name',
        label: $t('the_child')
    },
    {
        value: 'baby_milk_quantity',
        label: $t('baby_milk_quantity')
    },
    {
        value: 'diapers_quantity',
        label: $t('diapers_quantity')
    },
    {
        value: 'birth_date',
        label: $t('age')
    },
    {
        value: 'sponsor.name',
        label: $t('the_sponsor')
    }
]

export const meatDistributionSorts = [
    {
        value: 'sponsor.name',
        label: $t('the_sponsor')
    },
    {
        value: 'aggregate_white_meat_benefit',
        label: $t('aggregate_white_meat_benefit')
    },
    {
        value: 'aggregate_red_meat_benefit',
        label: $t('aggregate_red_meat_benefit')
    },
    {
        value: 'address.zone.name',
        label: $t('validation.attributes.address')
    },
    {
        value: 'branch.name',
        label: $t('the_branch')
    },
    {
        value: 'orphans_count',
        label: $t('orphans_count')
    },
    {
        value: 'income_rate',
        label: $t('income_rate')
    },
    {
        value: 'total_income',
        label: $t('filters.total_income')
    }
]

export const benefactorsSorts = [
    {
        value: 'name',
        label: $t('the_benefactor')
    },
    {
        value: 'sponsorships_count',
        label: $t('sponsorships_count')
    },
    {
        value: 'created_at',
        label: $t('added_at')
    }
]

export const financesSorts = [
    {
        value: 'creator.name',
        label: $t('receiving_member')
    },
    {
        value: 'amount',
        label: $t('the_amount')
    },
    {
        value: 'created_at',
        label: $t('added_at')
    },
    {
        value: `specification.${getLocale()}`,
        label: $t('filters.finance_specification')
    },
    {
        value: 'date',
        label: $t('the date')
    }
]

export const needsSorts = [
    {
        value: 'name',
        label: $t('the_need')
    },
    {
        value: 'members_count',
        label: $t('members_count')
    },
    {
        value: 'created_at',
        label: $t('filters.created_at')
    }
]

export const transcriptsSorts = [
    {
        value: 'name',
        label: $t('the_child')
    },
    {
        value: 'academic_level.i_id',
        label: $t('academic_level')
    },
    {
        value: 'birth_date',
        label: $t('filters.birth_date')
    },
    {
        value: 'institution.name',
        label: $t('validation.attributes.institution')
    },
    {
        value: 'academic_average',
        label: $t('general_average')
    },
    {
        value: 'sponsor.name',
        label: $t('the_sponsor')
    }
]
export const inventorySorts = [
    {
        value: 'name',
        label: $t('the_item')
    },
    {
        value: 'qty',
        label: $t('validation.attributes.amount')
    },
    {
        value: 'created_at',
        label: $t('added_at')
    }
]
export const privateSchoolsSorts = [
    {
        value: 'name',
        label: $t('the_school')
    },
    {
        value: 'quota',
        label: $t('quota_total')
    },
    {
        value: 'created_at',
        label: $t('added_at')
    }
]
