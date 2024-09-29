import type { LangType } from '@/types/types'

import { type App, ref } from 'vue'

const locale = ref('ar') // default locale

const langData = ref<Record<string, string>>({})

async function fetchLocale() {
    const response = await fetch(`/locales/${locale.value}.json`)

    langData.value = await response.json()
}

function setLocale(newLocale: LangType) {
    locale.value = newLocale

    fetchLocale().then()
}

export function getLocale(): LangType {
    return locale.value
}

export function $t(key: string, replacements: Record<string, string> = {}) {
    let translation = langData.value[key] || key

    Object.keys(replacements).forEach((replacement) => {
        if (replacement === 'total' && replacements[replacement] == 2)
            translation = translation.replace(`:${replacement}`, '')
        else translation = translation.replace(`:${replacement}`, replacements[replacement])
    })

    return translation
}

const getInputPhrase = (count, rules) => {
    for (const rule of rules) {
        if (count >= rule.min && count <= rule.max) {
            return rule.phrase
        }
    }
    return '' // or some default phrase
}

export function $tc(key: string, number: number, replacements: Record<string, string> = {}) {
    const rules = []
    const parts = $t(key).split('|')
    parts.forEach((part) => {
        const match = part.match(/\{.*?}|\[.*?]/)
        if (match === null) {
            return
        }
        const condition = part.match(/\{.*?}|\[.*?]/)[0]
        const phrase = $t(part.replace(condition, ''), replacements)
        let min, max

        if (condition.startsWith('{') && condition.endsWith('}')) {
            min = parseInt(condition.substring(1, condition.length - 1), 10)
            max = min
        } else if (condition.startsWith('[') && condition.endsWith(']')) {
            const range = condition.substring(1, condition.length - 1).split(',')
            min = parseInt(range[0], 10)
            max = range[1] === '*' ? Infinity : parseInt(range[1], 10)
        }

        rules.push({
            min,
            max,
            phrase: phrase.trim()
        })
    })
    if (rules.length === 0) {
        return parts[0]
    }
    return getInputPhrase(number, rules)
}

export default {
    install(app: App) {
        app.config.globalProperties.$t = (key: string, replacements: Record<string, string> = {}) =>
            $t(key, replacements)

        app.config.globalProperties.n__ = (key: string, number: number, replacements: Record<string, string> = {}) =>
            $tc(key, number, replacements)

        app.provide('locale', locale)

        app.provide('langData', langData)

        fetchLocale().then()
    },
    setLocale,
    getLocale
}
