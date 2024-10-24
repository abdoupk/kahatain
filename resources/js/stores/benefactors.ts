import type { Benefactor } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    benefactor: Benefactor & {
        readable_created_at?: string
        creator?: {
            id: string
            name: string
        }
    }
    benefactors: Benefactor[]
}

export const useBenefactorsStore = defineStore('benefactors', {
    state: (): State => ({
        benefactor: {
            first_name: '',
            last_name: '',
            id: '',
            phone: '',
            address: '',
            location: {
                lat: null,
                lng: null
            },
            creator: {
                id: '',
                name: ''
            },
            sponsorships: []
        },
        benefactors: []
    }),
    actions: {
        async getBenefactor(benefactorId: string) {
            await axios.get(route('tenant.benefactors.show', benefactorId)).then((res) => {
                this.benefactor = res.data.benefactor
            })
        },

        async getBenefactorDetails(benefactorId: string) {
            const { data } = await axios.get(route('tenant.benefactors.details', benefactorId))

            this.benefactor = data.benefactor
        },

        async getBenefactors() {
            if (this.benefactors.length > 0) {
                return
            }

            const { data: benefactors } = await axios.get(route('tenant.list.benefactors'))

            this.benefactors = benefactors
        },

        findBenefactorById(id: string) {
            return this.benefactors.find((benefactor) => benefactor.id === id)
        },

        async searchBenefactors(search: string) {
            const { data: benefactors } = await axios.get(route('tenant.benefactors.search', { search }))

            this.benefactors = benefactors
        }
    }
})
