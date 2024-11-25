import type { IFormattedMenu } from '@/types/types'

import { defineStore } from 'pinia'

import { hasPermission } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

export const useMenuStore = defineStore('menu', {
    state: (): { menu: Array<IFormattedMenu | 'divider'> } => ({
        menu: [
            {
                icon: 'icon-house',
                routeName: 'tenant.dashboard',
                url: '/dashboard',
                title: $t('dashboard')
            },
            // eslint-disable-next-line array-element-newline
            hasPermission(['list_roles', 'list_members', 'list_branches', 'list_zones']) ? 'divider' : '',
            {
                icon: 'icon-user-lock',
                ignore: !hasPermission('list_roles'),
                routeName: 'tenant.roles.index',
                url: '/dashboard/roles',
                title: $t('roles')
            },
            {
                icon: 'icon-users-gear',
                ignore: !hasPermission('list_members'),
                title: $t('the_members'),
                routeName: 'tenant.members.index',
                url: '/dashboard/members'
            },
            {
                icon: 'icon-branches',
                ignore: !hasPermission('list_branches'),
                title: $t('branches'),
                routeName: 'tenant.branches.index',
                url: '/dashboard/branches'
            },
            {
                icon: 'icon-users',
                ignore: !hasPermission('list_committees'),
                title: $t('the_committees'),
                routeName: 'tenant.committees.index',
                url: '/dashboard/committees'
            },
            {
                icon: 'icon-map-location-dot',
                ignore: !hasPermission('list_zones'),
                title: $t('the_zones'),
                routeName: 'tenant.zones.index',
                url: '/dashboard/zones'
            },
            // eslint-disable-next-line array-element-newline
            hasPermission(['list_orphans', 'list_sponsors', 'list_families', 'create_families', 'view_occasions'])
                ? 'divider'
                : '',
            {
                icon: 'icon-family',
                ignore: !hasPermission(['list_families', 'create_families']),
                routeName: '',
                title: $t('the_families'),
                subMenu: [
                    {
                        icon: 'icon-users',
                        ignore: !hasPermission('list_families'),
                        title: $t('list', { attribute: $t('the_families') }),
                        routeName: 'tenant.families.index',
                        url: '/dashboard/families'
                    },
                    {
                        icon: 'icon-users-plus',
                        ignore: !hasPermission('create_families'),
                        title: $tc($t('add new'), 0, { attribute: $t('family') }),
                        routeName: 'tenant.families.create',
                        url: '/dashboard/families/create'
                    },
                    {
                        icon: 'icon-chart-pie-simple',
                        title: $t('statistics'),
                        routeName: 'tenant.families.statistics',
                        url: '/dashboard/families/statistics'
                    }
                ]
            },
            {
                icon: 'icon-children',
                ignore: !hasPermission('list_orphans'),
                title: $t('orphans'),
                routeName: '',
                subMenu: [
                    {
                        icon: 'icon-children',
                        ignore: !hasPermission('list_orphans'),
                        title: $t('list', { attribute: $t('orphans') }),
                        routeName: 'tenant.orphans.index',
                        url: '/dashboard/orphans'
                    },
                    {
                        icon: 'icon-chart-pie-simple',
                        title: $t('statistics'),
                        routeName: 'tenant.orphans.statistics',
                        url: '/dashboard/orphans/statistics'
                    }
                ]
            },
            {
                icon: 'icon-hands-holding-child',
                ignore: !hasPermission('list_sponsors'),
                title: $t('the_sponsors'),
                routeName: '',
                url: '',
                subMenu: [
                    {
                        icon: 'icon-hands-holding-child',
                        ignore: !hasPermission('list_sponsors'),
                        title: $t('list', { attribute: $t('sponsors') }),
                        routeName: 'tenant.sponsors.index',
                        url: '/dashboard/sponsors'
                    },
                    {
                        icon: 'icon-chart-pie-simple',
                        title: $t('statistics'),
                        routeName: 'tenant.sponsors.statistics',
                        url: '/dashboard/sponsors/statistics'
                    }
                ]
            },
            {
                icon: 'icon-calendar-star',
                routeName: '',
                title: $t('breadcrumb.projects'),
                ignore: !hasPermission('view_occasions'),
                subMenu: [
                    {
                        icon: 'icon-money',
                        // Ignore: !hasPermission('list_permission'),
                        title: $t('direct_bail'),
                        routeName: 'tenant.monthly-sponsorship.index',
                        url: '/dashboard/projects/monthly-sponsorship'
                    },
                    {
                        icon: 'icon-ram',
                        // Ignore: !hasPermission('list_permission'),
                        title: $t('eid_el_adha'),
                        routeName: 'tenant.occasions.eid-al-adha.index',
                        url: '/dashboard/projects/eid-al-adha'
                    },
                    {
                        icon: 'icon-zakat',
                        // Ignore: !hasPermission('list_permission'),
                        title: $t('zakat'),
                        routeName: 'tenant.occasions.zakat.index',
                        url: '/dashboard/projects/zakat'
                    },
                    {
                        icon: 'icon-backpack',
                        // Ignore: !hasPermission('list_permission'),
                        title: $t('school_entry'),
                        routeName: 'tenant.occasions.school-entry.index',
                        url: '/dashboard/projects/school-entry'
                    },
                    {
                        icon: 'icon-moon-stars',
                        // Ignore: !hasPermission('list_permission'),
                        title: $t('eid_el_fitr'),
                        routeName: 'tenant.occasions.eid-suit.index',
                        url: '/dashboard/projects/eid-suit'
                    },
                    {
                        icon: 'icon-moon',
                        // Ignore: !hasPermission('list_permission'),
                        title: $t('ramadan basket'),
                        routeName: 'tenant.occasions.ramadan-basket.index',
                        url: '/dashboard/projects/ramadan-basket'
                    },
                    // {
                    //     Icon: 'icon-basket-shopping',
                    //     // Ignore: !hasPermission('list_permission'),
                    //     Title: $t('monthly basket'),
                    //     RouteName: 'tenant.occasions.monthly-basket.index',
                    //     Url: '/dashboard/projects/monthly-basket'
                    // },
                    {
                        icon: 'icon-baby-carriage',
                        // Ignore: !hasPermission('list_permission'),
                        title: $t('milk and diapers'),
                        routeName: 'tenant.occasions.babies-milk-and-diapers.index',
                        url: '/dashboard/projects/babies-milk-and-diapers'
                    }
                ]
            },
            {
                icon: 'icon-hands-holding-dollar',
                // eslint-disable-next-line capitalized-comments
                // ignore: !hasPermission('list_schools'),
                routeName: 'tenant.benefactors.index',
                title: $t('benefactors'),
                url: '/dashboard/benefactors'
            },
            // eslint-disable-next-line array-element-newline
            hasPermission(['list_financial_transactions', 'list_lessons', 'create_lessons', 'list_needs'])
                ? 'divider'
                : '',
            {
                icon: 'icon-treasure-chest',
                title: $t('financial'),
                routeName: '',
                ignore: !hasPermission(['list_financial_transactions', 'view_financial_transactions']),
                subMenu: [
                    {
                        icon: 'icon-hands-holding-dollar',
                        ignore: !hasPermission('list_financial_transactions'),
                        title: $t('financial'),
                        routeName: 'tenant.financial.index',
                        url: '/dashboard/financial'
                    },
                    {
                        ignore: !hasPermission(['list_financial_transactions', 'view_financial_transactions']),
                        icon: 'icon-chart-pie-simple',
                        title: $t('statistics'),
                        routeName: 'tenant.financial.statistics',
                        url: '/dashboard/financial/statistics'
                    }
                ]
            },
            {
                icon: 'icon-handshake-angle',
                ignore: !hasPermission('list_needs'),
                title: $t('the_needs'),
                routeName: 'tenant.needs.index',
                url: '/dashboard/needs'
            },
            {
                icon: 'icon-graduation-cap',
                ignore: !hasPermission('list_lessons'),
                routeName: 'tenant.lessons.index',
                title: $t('private_lessons'),
                url: '/dashboard/lessons'
            },
            {
                icon: 'icon-user-graduate',
                // Ignore: !hasPermission('list_permission'),
                title: $t('orphan_students'),
                routeName: 'tenant.students.index',
                url: '/dashboard/students'
            },
            {
                icon: 'icon-grid',
                // Ignore: !hasPermission('list_permission'),
                title: $t('transcripts'),
                routeName: 'tenant.transcripts.index',
                url: '/dashboard/transcripts'
            },
            {
                icon: 'icon-school-lock',
                ignore: !hasPermission('list_schools'),
                routeName: 'tenant.schools.index',
                title: $t('private_schools'),
                url: '/dashboard/schools'
            },
            // eslint-disable-next-line array-element-newline
            hasPermission(['list_archive', 'list_items', 'list_trash', 'view_settings']) ? 'divider' : '',
            {
                icon: 'icon-shelves',
                ignore: !hasPermission('list_inventory'),
                title: $t('the_inventory'),
                routeName: 'tenant.inventory.index',
                url: '/dashboard/inventory'
            },
            {
                icon: 'icon-trash-list',
                ignore: !hasPermission('list_permission'),
                routeName: 'tenant.trash',
                title: $t('the_trash'),
                url: '/dashboard/trash'
            },
            {
                icon: 'icon-box-archive',
                ignore: !hasPermission('list_archive'),
                routeName: 'tenant.archive.index',
                title: $t('the_archive'),
                url: '/dashboard/archive'
            },
            {
                icon: 'icon-gear',
                ignore: !hasPermission('list_settings'),
                routeName: 'tenant.settings.index',
                title: $t('settings'),
                url: '/dashboard/settings'
            }
        ]
    })
})
