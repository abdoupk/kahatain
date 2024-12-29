import { $t } from '@/utils/i18n'

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
        label: $t('sorts.role')
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
