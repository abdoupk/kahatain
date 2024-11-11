import type { IFormattedMenu, ILocation, IMenu } from '@/types/types'

import { router, usePage } from '@inertiajs/vue3'

import { pathNameOfCurrentPage, slideDown, slideUp } from '@/utils/helper'

const findActiveMenu = (subMenu: IMenu[], route: ILocation) => {
    let match = false

    subMenu.forEach((item: IMenu) => {
        if (usePage().url.startsWith(item.url) && !item.ignore) {
            match = true
        } else if (!match && item.subMenu) {
            match = findActiveMenu(item.subMenu, route)
        }
    })

    return match
}

const nestedMenu = (menu: Array<IMenu | 'divider'>, route: ILocation) => {
    const formattedMenu: Array<IFormattedMenu | 'divider'> = []

    menu.forEach((item) => {
        if (typeof item !== 'string') {
            const menuItem: IFormattedMenu = {
                url: item.url,
                icon: item.icon,
                title: item.title,
                routeName: item.routeName,
                subMenu: item.subMenu,
                ignore: item.ignore
            }

            menuItem.active =
                pathNameOfCurrentPage() === item.url ||
                (menuItem.subMenu && findActiveMenu(menuItem.subMenu, route) && !menuItem.ignore)

            if (menuItem.subMenu) {
                menuItem.activeDropdown = findActiveMenu(menuItem.subMenu, route)

                // Nested menu
                const subMenu: Array<IFormattedMenu> = []

                nestedMenu(menuItem.subMenu, route).map((menu) => typeof menu !== 'string' && subMenu.push(menu))

                menuItem.subMenu = subMenu
            }

            formattedMenu.push(menuItem)
        } else {
            if (item === 'divider') formattedMenu.push(item)
        }
    })

    return formattedMenu
}

const linkTo = async (menu: IFormattedMenu, event: Event) => {
    if (menu.subMenu) {
        menu.activeDropdown = !menu.activeDropdown
    } else {
        event.preventDefault()

        if (menu.url === usePage().url) {
            return
        }

        console.log(menu.url)

        router.get(menu.routeName !== '' ? route(menu.routeName) : '#')
    }
}

const enter = (el: Element, done: () => void) => {
    slideDown(el, 300, done)
}

const leave = (el: Element, done: () => void) => {
    slideUp(el, 300, done)
}

export { nestedMenu, linkTo, enter, leave }
