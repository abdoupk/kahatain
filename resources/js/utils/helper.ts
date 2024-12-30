import type { AppearanceType, ColorSchemesType, FontSizeType, IndexParams, ListBoxFilter } from '@/types/types'

import { router, usePage } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import 'dayjs/locale/ar'
import 'dayjs/locale/fr'
import { computed } from 'vue'

import { $t, getLocale } from '@/utils/i18n'

const downloadFile = (url: string, filename: string) => {
    const a = document.createElement('a')
    a.href = url
    a.download = filename || '' // Set the filename if provided

    // Append the anchor to the body (required for Firefox)
    document.body.appendChild(a)

    // Programmatically click the anchor to trigger the download
    a.click()

    // Remove the anchor from the document
    document.body.removeChild(a)
}
const toRaw = (obj: object) => {
    return JSON.parse(JSON.stringify(obj))
}

// noinspection JSUnusedLocalSymbols
const slideUp = (el: HTMLElement, duration = 300, callback = (el: HTMLElement) => {}) => {
    el.style.transitionProperty = 'height, margin, padding'

    el.style.transitionDuration = duration + 'ms'

    el.style.height = el.offsetHeight + 'px'

    el.offsetHeight

    setSlideProperties(el)

    window.setTimeout(() => {
        el.style.display = 'none'

        el.style.removeProperty('height')

        el.style.removeProperty('padding-top')

        el.style.removeProperty('padding-bottom')

        el.style.removeProperty('margin-top')

        el.style.removeProperty('margin-bottom')

        el.style.removeProperty('overflow')

        el.style.removeProperty('transition-duration')

        el.style.removeProperty('transition-property')

        callback(el)
    }, duration)
}

const setSlideProperties = (el: HTMLElement) => {
    el.style.overflow = 'hidden'

    el.style.height = '0'

    el.style.paddingTop = '0'

    el.style.paddingBottom = '0'

    el.style.marginTop = '0'

    el.style.marginBottom = '0'
}

// noinspection JSUnusedLocalSymbols
const slideDown = (el: HTMLElement, duration = 300, callback = (el: HTMLElement) => {}) => {
    el.style.removeProperty('display')

    let display = window.getComputedStyle(el).display

    if (display === 'none') display = 'block'

    el.style.display = display

    const height = el.offsetHeight

    setSlideProperties(el)

    el.offsetHeight

    el.style.transitionProperty = 'height, margin, padding'

    el.style.transitionDuration = duration + 'ms'

    el.style.height = height + 'px'

    el.style.removeProperty('padding-top')

    el.style.removeProperty('padding-bottom')

    el.style.removeProperty('margin-top')

    el.style.removeProperty('margin-bottom')

    window.setTimeout(() => {
        el.style.removeProperty('height')

        el.style.removeProperty('overflow')

        el.style.removeProperty('transition-duration')

        el.style.removeProperty('transition-property')

        callback(el)
    }, duration)
}

const setDarkModeClass = (appearance: AppearanceType) => {
    appearance === 'dark'
        ? document.documentElement.classList.add('dark')
        : document.documentElement.classList.remove('dark')
}

const setColorSchemeClass = (colorScheme: ColorSchemesType, appearance: AppearanceType) => {
    const el = document.querySelectorAll('html')[0]

    el.setAttribute('class', colorScheme)

    appearance === 'dark' && el.classList.add('dark')
}

const setFontSizeClass = (fontSize: FontSizeType) => {
    const el = document.querySelectorAll('html')[0]

    el.classList.add(fontSize.replaceAll('_', '-'))
}

const isEmpty = (value) => {
    if (Array.isArray(value)) {
        return value.length === 0 || value.every((item) => isEmpty(item))
    } else if (typeof value === 'object' && value !== null) {
        return Object.keys(value).length === 0 || Object.values(value).every((item) => isEmpty(item))
    } else {
        return value === null || value === undefined || value === '' || value === false || value === 0
    }
}
const omit = (obj: any, props: any): any => {
    obj = { ...obj }

    props.forEach((prop: any) => delete obj[prop])

    return obj
}

function isEqual(x: any, y: any): any {
    const ok = Object.keys,
        tx = typeof x,
        ty = typeof y

    return x && y && tx === 'object' && tx === ty
        ? ok(x).length === ok(y).length && ok(x).every((key) => isEqual(x[key], y[key]))
        : x === y
}

const allowOnlyNumbersOnKeyDown = (event: KeyboardEvent) => {
    // eslint-disable-next-line array-element-newline
    if (
        !['Backspace', 'Tab', 'Enter', 'Delete', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(
            event.key
        ) &&
        !/[0-9]/.test(event.key)
    ) {
        event.preventDefault()
    }
}

const debounce = (func, delay, { leading } = {}) => {
    let timerId

    return (...args) => {
        if (!timerId && leading) {
            func(...args)
        }
        clearTimeout(timerId)

        timerId = setTimeout(() => func(...args), delay)
    }
}

const checkErrors = (pattern: string, errors?: Record<string, string>) => {
    const regex = new RegExp(pattern)

    return (
        errors &&
        Object.keys(errors).some((error) => {
            if (regex.test(error)) return true
        })
    )
}

const handleSort = (field: string, params: IndexParams) => {
    params.fields = (params?.fields ?? []) || []

    params.directions = { ...params.directions }

    if (params.fields.includes(field)) {
        const idx = params.fields.indexOf(field)

        if (params.directions[field] === 'asc') {
            params.directions[field] = 'desc'
        } else {
            params.fields.splice(idx, 1)

            delete params.directions[field]
        }
    } else {
        params.fields.push(field)

        params.directions[field] = 'asc'
    }

    return params
}

const isAssociationNameLatin = computed(() => {
    return /^[a-z]+/i.test(usePage().props.association)
})

const pathNameOfCurrentPage = (): string => {
    const parsedUrl = new URL(usePage().url, import.meta.env.VITE_APP_URL)

    // Remove the search parameters
    parsedUrl.search = ''

    return parsedUrl.pathname.toString()
}

const formatDate = (date: string | Date, dateStyle: 'full' | 'long' | 'medium' | 'short' | undefined) => {
    if (!date) return '————'
    try {
        return new Intl.DateTimeFormat(`${getLocale()}-DZ`, {
            dateStyle
        }).format(new Date(date))
    } catch ($e) {
        return ''
    }
}

const formatDateAndTime = (date: string | Date) => {
    return dayjs(date)
        .locale(getLocale() + '-DZ')
        .format('DD MMMM YYYY hh:mm A')
}

const formatDateAndTimeShort = (date: string | Date) => {
    return dayjs(date)
        .locale(getLocale() + '-DZ')
        .format('DD MMMM hh:mm A')
}

const formatCurrency = (amount) => {
    try {
        if (isNaN(amount)) amount = 0

        return new Intl.NumberFormat(`${getLocale()}-DZ`, { style: 'currency', currency: 'DZD' }).format(amount)
    } catch ($e) {
        return ''
    }
}

const handleSponsorship = (sponsorshipValue: string) => {
    if (sponsorshipValue === '0' || sponsorshipValue === false) {
        return $t('no')
    }

    if (sponsorshipValue === '1' || sponsorshipValue === true) {
        return $t('yes')
    }

    const parsedValue = parseFloat(sponsorshipValue)

    if (!isNaN(parsedValue)) {
        return formatCurrency(parsedValue)
    } else {
        return sponsorshipValue || '————'
    }
}

const handleFurnishings = (sponsorshipValue) => {
    let text = ''
    if (sponsorshipValue.checked) {
        text = $t('yes')
    } else {
        text = $t('no')
    }

    if (sponsorshipValue.note && sponsorshipValue.note.length > 0) {
        text += ` (${sponsorshipValue.note})`
    }

    return text
}

const groupByKey = (arr, key) => {
    return arr.reduce((acc, current) => {
        ;(acc[current[key]] = acc[current[key]] || []).push(current)
        return acc
    }, {})
}

const formatNumber = (value: number) => {
    return new Intl.NumberFormat(`${getLocale()}-DZ`).format(value)
}

function setDateToCurrentTime(value: string | Date) {
    const currentTime = dayjs()

    return dayjs(value)
        .startOf('day')
        .add(currentTime.valueOf() - currentTime.startOf('day').valueOf(), 'millisecond')
}

function getAcademicLevelFromId(id, academicLevels) {
    if (!id) return ''
    else {
        return academicLevels.reduce((acc, curr) => {
            const level = curr.levels.find((level) => level.id === id)

            if (level) acc = level

            return acc
        }, {})
    }
}

function getVocationalTrainingSpecialityFromId(id, specialities) {
    if (!id) return ''
    else {
        return specialities.reduce((acc, curr) => {
            const speciality = curr.specialities.find((speciality) => Number(speciality.id) === id)
            if (speciality) acc = speciality

            return acc
        }, {})
    }
}

function handleFilterValue(filter: ListBoxFilter, value): string {
    if (filter.field === 'furnishings') {
        return true
    } else if (filter.type === 'date') {
        const convertedDate = Date.parse(value) / 1000

        if (isNaN(convertedDate)) return ''

        return convertedDate.toString()
    } else if (filter.field === 'sponsorship') {
        if (value.value !== '') return true

        return ''
    } else if (filter.field === 'family_sponsorships' || filter.field === 'sponsorships') {
        if (value.value !== '') return true

        return ''
    } else if (filter.type === 'object') {
        if (value?.id !== undefined) return value.id
        else return value.value
    } else if (filter.type === 'number') {
        if (typeof value === 'object') return ''
    } else if (filter.field === 'roles' || filter.field === 'committees' || filter.field === 'competences') {
        if (value) return `[${value}]`
    }
    return value
}

const handleFilterName = (field: ListBoxFilter, value: { value: string } | string): string => {
    const isSponsorship = ['family_sponsorships', 'sponsor_sponsorships'].includes(field.label)

    const isOrphanSponsorship = field.label === 'orphan_sponsorships'

    if (field.field === 'sponsorship' && typeof value !== 'string') {
        return `${value.value}`
    } else if (isSponsorship && typeof value !== 'string') {
        return `${field.label}.${value.value}`
    } else if (isOrphanSponsorship && typeof value !== 'string') {
        return `${field.field}.${value.value}`
    } else if (field.field === 'furnishings') {
        if (value?.value) return `${field.label}.${value.value}.checked`
        return ''
    } else {
        return field.field || field
    }
}

const formatUrl = (url: string) => {
    const parsedUrl = new URL(url)

    const searchParams = parsedUrl.searchParams

    for (const [key, value] of searchParams.entries()) {
        if (value === '') {
            searchParams.delete(key)
        }
    }

    parsedUrl.search = searchParams.toString()

    return parsedUrl.toString()
}

const formatFilters = (filters) => {
    return {
        ...filters
            ?.map((filter) => {
                return {
                    field: handleFilterName(filter.field, filter.value),
                    operator: filter?.operator?.value ?? filter.operator,
                    value: handleFilterValue(filter.field, filter.value)
                }
            })
            .filter((filter) => filter?.operator && filter.operator !== '')
            .filter((filter) => filter?.value !== undefined && filter.value !== '')
            .filter((filter) => filter?.field)
    }
}

const getDataForIndexPages = (url: string, params: IndexParams, options: object) => {
    router.get(url, formatParams(params), options)
}

const formatParams = (params: IndexParams) => {
    let data = { ...params }

    if (params?.search === '' || params?.search === undefined) {
        delete data.search
    }

    Object.keys(data).forEach((key) => {
        if (!data[key as keyof IndexParams]) delete data[key as keyof IndexParams]
    })

    data.filters = formatFilters(data.filters)

    return data
}

function hasPermission(permission) {
    if (typeof permission === 'string') {
        return (
            usePage().props.auth.user.roles.includes('super_admin') ||
            usePage().props.auth.user.permissions.includes(permission.toString())
        )
    } else if (Array.isArray(permission)) {
        return (
            usePage().props.auth.user.roles.includes('super_admin') ||
            usePage().props.auth.user.permissions.some((item) => permission.includes(item))
        )
    } else {
        return false
    }
}

function hexToRgba(hex, opacity) {
    // Remove the hash at the start if it's there
    hex = hex.replace(/^#/, '')

    // Parse the r, g, b values
    let r = parseInt(hex.substring(0, 2), 16)
    let g = parseInt(hex.substring(2, 4), 16)
    let b = parseInt(hex.substring(4, 6), 16)

    // Return the RGBA string
    return `rgba(${r}, ${g}, ${b}, ${opacity})`
}

// Function to add opacity to an array of hex colors
function addOpacityToHexColor(hexColor, opacity) {
    return hexToRgba(hexColor, opacity)
}

function getMarkerIcon(color) {
    return window.btoa(`<svg xmlns="http://www.w3.org/2000/svg" width="20" height="31.063" viewBox="0 0 20 31.063">
              <g id="Group_16" data-name="Group 16" transform="translate(-408 -150.001)">
                <path id="Subtraction_21" data-name="Subtraction 21" d="M10,31.064h0L1.462,15.208A10,10,0,1,1,20,10a9.9,9.9,0,0,1-1.078,4.522l-.056.108c-.037.071-.077.146-.121.223L10,31.062ZM10,2a8,8,0,1,0,8,8,8,8,0,0,0-8-8Z" transform="translate(408 150)" fill="${color}"/>
                <circle id="Ellipse_26" data-name="Ellipse 26" cx="6" cy="6" r="6" transform="translate(412 154)" fill="${color}"/>
              </g>
            </svg>
          `)
}

function getMarkerRegionIcon(color) {
    return window.btoa(`<svg xmlns="http://www.w3.org/2000/svg" width="55.066" height="47.691" viewBox="0 0 55.066 47.691">
                <g id="Group_15" data-name="Group 15" transform="translate(-319.467 -83.991)">
                  <g id="Group_14" data-name="Group 14">
                    <path id="Intersection_4" data-name="Intersection 4" d="M12.789,17.143a15,15,0,0,1,20.7,0l-1.6,2.141-.018-.018a12.352,12.352,0,0,0-17.469,0l-.018.018Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.845"/>
                    <path id="Intersection_5" data-name="Intersection 5" d="M10.384,13.919a19,19,0,0,1,25.511,0l-2.016,2.7a15.647,15.647,0,0,0-21.479,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.652"/>
                    <path id="Intersection_6" data-name="Intersection 6" d="M7.982,10.7a22.978,22.978,0,0,1,30.313,0l-2,2.679a19.652,19.652,0,0,0-26.316,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.453"/>
                  </g>
                  <g id="Group_13" data-name="Group 13" transform="translate(427.806 461.061) rotate(-120)">
                    <path id="Intersection_4-2" data-name="Intersection 4" d="M12.789,17.143a15,15,0,0,1,20.7,0l-1.6,2.141-.018-.018a12.352,12.352,0,0,0-17.469,0l-.018.018Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.845"/>
                    <path id="Intersection_5-2" data-name="Intersection 5" d="M10.384,13.919a19,19,0,0,1,25.511,0l-2.016,2.7a15.647,15.647,0,0,0-21.479,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.652"/>
                    <path id="Intersection_6-2" data-name="Intersection 6" d="M7.982,10.7a22.978,22.978,0,0,1,30.313,0l-2,2.679a19.652,19.652,0,0,0-26.316,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.453"/>
                  </g>
                  <circle id="Ellipse_9" data-name="Ellipse 9" cx="11" cy="11" r="11" transform="translate(336 96)" fill="${color}"/>
                  <g id="Group_12" data-name="Group 12" transform="translate(613.194 -139.96) rotate(120)">
                    <path id="Intersection_4-3" data-name="Intersection 4" d="M12.789,17.143a15,15,0,0,1,20.7,0l-1.6,2.141-.018-.018a12.352,12.352,0,0,0-17.469,0l-.018.018Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.845"/>
                    <path id="Intersection_5-3" data-name="Intersection 5" d="M10.384,13.919a19,19,0,0,1,25.511,0l-2.016,2.7a15.647,15.647,0,0,0-21.479,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.652"/>
                    <path id="Intersection_6-3" data-name="Intersection 6" d="M7.982,10.7a22.978,22.978,0,0,1,30.313,0l-2,2.679a19.652,19.652,0,0,0-26.316,0Z" transform="translate(323.861 78.999)" fill="${color}" opacity="0.453"/>
                  </g>
                </g>
              </svg>
            `)
}

function sumObjectValues(obj): number {
    return Object.values(obj).reduce((sum, value) => sum + value, 0)
}

const isOlderThan = (date: string, age: number) => {
    return dayjs().diff(dayjs(date), 'year') >= age
}

function getRandomItemWithoutRepeat(items) {
    const itemsCopy = [...items]

    if (itemsCopy.length === 0) return null

    const randomIndex = Math.floor(Math.random() * itemsCopy.length)

    return itemsCopy.splice(randomIndex, 1)[0]
}

const getLeafletMapConfig = () => {
    let config = {
        center: [28.0339, 1.6596],
        zoom: 4,
        minZoom: 4
    }

    if (usePage().props.association_coordinates.lat && usePage().props.association_coordinates.lng) {
        config = {
            center: [usePage().props.association_coordinates.lat, usePage().props.association_coordinates.lng],
            zoom: 14,
            minZoom: 6
        }
    }

    return config
}

const groupRecentActivitiesByDate = (activities) => {
    return activities.reduce((acc, item) => {
        const date = dayjs(item.date).format('YYYY-MM-DD')
        if (!acc[date]) {
            acc[date] = []
        }
        acc[date].push(item)
        return acc
    }, {})
}

function removeEmptyKeys(obj) {
    Object.keys(obj).forEach((key) => {
        if (obj[key] === null || obj[key] === '') {
            delete obj[key]
        }
    })
    return obj
}

export {
    isEqual,
    removeEmptyKeys,
    getLeafletMapConfig,
    groupRecentActivitiesByDate,
    hasPermission,
    getRandomItemWithoutRepeat,
    isOlderThan,
    addOpacityToHexColor,
    sumObjectValues,
    formatFilters,
    getDataForIndexPages,
    handleFilterValue,
    formatDate,
    formatUrl,
    getAcademicLevelFromId,
    getVocationalTrainingSpecialityFromId,
    setDateToCurrentTime,
    formatNumber,
    isAssociationNameLatin,
    groupByKey,
    handleSponsorship,
    handleFurnishings,
    formatCurrency,
    handleSort,
    omit,
    toRaw,
    slideUp,
    debounce,
    slideDown,
    setDarkModeClass,
    isEmpty,
    setColorSchemeClass,
    allowOnlyNumbersOnKeyDown,
    formatDateAndTime,
    checkErrors,
    pathNameOfCurrentPage,
    getMarkerRegionIcon,
    getMarkerIcon,
    formatParams,
    formatDateAndTimeShort,
    setFontSizeClass,
    downloadFile
}
