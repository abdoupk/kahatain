import type { CityType, CreateBranchForm } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

import { omit } from '@/utils/helper'

interface State {
    branch: CreateBranchForm & {
        id: string
        creator?: {
            id: string
            name: string
        }
        president?: {
            id: string
            name: string
        }
        readable_created_at: string
        city_name?: string
        families_count: number
        city: CityType
    }
    branches: { id: string; name: string; city_id: number }[]
}

export const useBranchesStore = defineStore('branches', {
    state: (): State => ({
        branch: {
            id: '',
            name: '',
            city_id: '',
            president_id: '',
            created_at: new Date()
        },
        branches: []
    }),
    actions: {
        async getBranch(branchId: string) {
            await axios.get(route('tenant.branches.show', branchId)).then((res) => {
                this.branch = omit(res.data.branch, [])
            })
        },

        async getBranchDetails(branchId: string) {
            const { data } = await axios.get(route('tenant.branches.details', branchId))

            this.branch = data.branch
        },

        async getBranches() {
            if (this.branches.length === 0) {
                const { data: branches } = await axios.get(route('tenant.list.branches'))

                this.branches = branches
            }
        },

        findBranchById(id: string) {
            return this.branches.find((branch) => branch.id === id)
        }
    }
})
