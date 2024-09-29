import axios from 'axios'
import { defineStore } from 'pinia'

export const useSizesStore = defineStore('sizes', {
    state: () => ({
        clothesSizes: [],
        shoesSizes: []
    }),
    actions: {
        async getClothesSizes() {
            if (this.clothesSizes.length > 0) {
                return
            }

            const response = await axios.get(route('tenant.list.clothes-sizes'))

            this.clothesSizes = response.data
        },

        async getShoesSizes() {
            if (this.shoesSizes.length > 0) {
                return
            }

            const response = await axios.get(route('tenant.list.shoes-sizes'))

            this.shoesSizes = response.data
        },

        findClothesSizeById(id: string) {
            return this.clothesSizes.find((size) => size.id == id)
        },

        findShoesSizeById(id: string) {
            return this.shoesSizes.find((size) => size.id == id)
        }
    }
})
