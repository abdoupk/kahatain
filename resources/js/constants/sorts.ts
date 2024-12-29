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

export const monthlySponsorshipSorts = []
export const eidAlAdhaSorts = []

export const zakatSorts = []
export const schoolEntrySorts = []

export const eidSuitSorts = []
export const ramadanBasketSorts = []

export const babiesMilkAndDiapersSorts = []

export const meatDistributionSorts = []

export const benefactorsSorts = []

export const financesSorts = []

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

export const transcriptsSorts = []
export const inventorySorts = []
export const privateSchoolsSorts = []
