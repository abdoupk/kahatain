import type { AppearanceType, ColorSchemesType, ISettingState, LayoutsType, ThemesType } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

export const useSettingsStore = defineStore('settings', {
    state: (): ISettingState => ({
        appearance: 'light',
        colorScheme: 'theme-1',
        theme: 'tinker',
        layout: 'side-menu',
        hints: {
            ramadan_basket: true,
            monthly_basket: true,
            eid_suit: true,
            school_entry: true,
            babies_milk_and_diapers: true,
            eid_al_adha: true
        }
    }),
    getters: {},
    actions: {
        async toggleAppearance(value: AppearanceType) {
            if (this.appearance !== value) {
                this.appearance = value

                await axios.put(route('tenant.profile.settings.update'), { appearance: value })
            }
        },

        async changeColorScheme(colorScheme: ColorSchemesType) {
            if (this.colorScheme !== colorScheme) {
                this.colorScheme = colorScheme

                await axios.put(route('tenant.profile.settings.update'), { color_scheme: colorScheme })
            }
        },

        async changeTheme(theme: ThemesType) {
            if (this.theme !== theme) {
                this.theme = theme

                await axios.put(route('tenant.profile.settings.update'), { theme })
            }
        },

        async changeLayout(layout: LayoutsType) {
            if (this.layout !== layout) {
                this.layout = layout

                await axios.put(route('tenant.profile.settings.update'), { layout })
            }
        },

        setHintToHidden(hint: string) {
            this.hints[hint] = false
        }
    }
})
