import { defineStore } from 'pinia'

export const useEidSuitsStore = defineStore('eid-suits', {
    state: () => ({
        shopNames: [],
        shopAddresses: [],
        shopPhoneNumbers: []
    }),
    actions: {
        async getShopNames() {
            if (this.shopNames.length > 0) {
                return
            }

            const { data } = await axios.get(route('tenant.list.list-shop-names'))

            this.shopNames = data
        },

        async getShopAddresses() {
            if (this.shopAddresses.length > 0) {
                return
            }

            const { data } = await axios.get(route('tenant.list.list-shop-adresses'))

            this.shopAddresses = data
        },

        async getShopPhoneNumbers() {
            if (this.shopPhoneNumbers.length > 0) {
                return
            }

            const { data } = await axios.get(route('tenant.list.list-shop-phone-numbers'))

            this.shopPhoneNumbers = data
        }
    },
    getters: {}
})
