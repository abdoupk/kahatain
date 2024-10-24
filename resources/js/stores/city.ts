import type { Commune, Daira, Wilaya } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

interface CityState {
    wilaya: Wilaya
    daira: Daira
    commune: Commune
    wilayas: Wilaya[]
    dairas: Daira[]
    communes: Commune[]
}

export const useCityStore = defineStore('city', {
    state: (): CityState => ({
        wilaya: {
            wilaya_code: '',
            wilaya_name: ''
        },
        daira: {
            daira_name: ''
        },
        commune: {
            commune_name: '',
            id: ''
        },
        wilayas: [],
        dairas: [],
        communes: []
    }),
    actions: {
        async fetchWilayas() {
            if (this.wilayas.length === 0) {
                const {
                    data: { wilayas }
                } = await axios.get(route('api.list-wilayas'))

                this.wilayas = wilayas
            }
        },

        async searchCities(search: string) {
            const { data: cities } = await axios.get(route('tenant.cities.search', { search }))

            return cities
        },

        async fetchDairas(wilaya_code: string | undefined) {
            if (typeof wilaya_code === 'undefined' || wilaya_code == '') return

            await axios
                .post(
                    route('api.dairas', {
                        wilaya_code: wilaya_code
                    })
                )
                .then((res) => {
                    this.dairas = res.data
                })
        },

        async fetchCommunes(daira_name: string | undefined, wilaya_code: string | undefined) {
            if (typeof daira_name === 'undefined' || typeof wilaya_code === 'undefined') {
                return
            }

            await axios
                .post(
                    route('api.communes', {
                        daira_name,
                        wilaya_code
                    })
                )
                .then((res) => {
                    this.communes = res.data
                })
        },

        getWilaya(wilaya_code: string | undefined) {
            if (typeof wilaya_code === 'undefined' || wilaya_code == '') this.wilaya = { wilaya_code: '' }

            this.wilaya = this.wilayas.find((wilaya) => wilaya.wilaya_code == wilaya_code)
        },

        getDaira(daira_name: string | undefined) {
            if (typeof daira_name === 'undefined' || daira_name == '') this.daira = { daira_name: '' }

            this.daira = this.dairas.find((daira) => daira.daira_name == daira_name)

            this.wilaya.wilaya_code = this.daira.wilaya_code
        },

        getCommune(id: number) {
            this.commune = this.communes.find((commune) => commune.id == id)
        }
    }
})
