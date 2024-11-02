import type { CreateSponsorshipForm } from '@/types/types'

import { defineStore } from 'pinia'

interface State {
    sponsorship: CreateSponsorshipForm & {
        id?: string
        recipientable?: {
            id: string
            name: string
            type: string
        }
    }
    sponsorships: CreateSponsorshipForm[]
    monthly_sponsorship: {
        university_scholarship_bachelor: number | null
        university_scholarship_master_one: number | null
        university_scholarship_master_two: number | null
        university_scholarship_doctorate: number | null
        unemployment_benefit: number | null
        threshold: number | null
        association_basket_value: number | null
        categories: {
            minimum: number | null
            maximum: number | null
            value: number | null
        }[]
    }
    ramadan_sponsorship: {
        threshold: number | null
        categories: {
            minimum: number | null
            maximum: number | null
            category: string | null
        }
    }
}

export const useSponsorshipsStore = defineStore('sponsorships', {
    state: (): State => ({
        sponsorships: [],
        sponsorship: {
            amount: null,
            sponsorship_type: '',
            recipientable_type: 'family',
            recipientable_id: '',
            benefactor: {
                id: '',
                name: ''
            },
            shop: {
                name: '',
                phone: '',
                address: ''
            }
        },
        monthly_sponsorship: {
            categories: [
                {
                    minimum: null,
                    maximum: null,
                    value: null
                }
            ],
            association_basket_value: null,
            threshold: null,
            unemployment_benefit: null,
            university_scholarship_bachelor: null,
            university_scholarship_master_one: null,
            university_scholarship_master_two: null,
            university_scholarship_doctorate: null
        },
        ramadan_sponsorship: {
            threshold: null,
            categories: [
                {
                    minimum: null,
                    maximum: null,
                    category: null
                }
            ]
        }
    }),
    actions: {
        async getMonthlySponsorshipSettings() {
            const { data: monthly_sponsorship } = await axios.get(route('tenant.monthly-sponsorship.get-settings'))

            this.monthly_sponsorship = monthly_sponsorship
        },

        async getRamadanSponsorshipSettings() {
            const { data: ramadan_sponsorship } = await axios.get(route('tenant.occasions.ramadan-basket.get-settings'))

            this.ramadan_sponsorship = ramadan_sponsorship
        }
    }
})
