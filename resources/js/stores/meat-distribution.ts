import { defineStore } from 'pinia'

interface State {
    meatDistribution: {
        families: string[]
        meat_type: 'white_meat' | 'red_meat'
    }
}

export const useMeatDistributionStore = defineStore('meat-distribution', {
    state: (): State => ({
        meatDistribution: {
            families: [],
            meat_type: 'white_meat'
        }
    })
})
