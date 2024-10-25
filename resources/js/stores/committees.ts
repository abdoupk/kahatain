import type { Committee } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    committee: Committee & {
        readable_created_at?: string
        creator?: {
            id: string
            name: string
        }
        families_count?: number
        members_count?: number
    }
    committees: Committee[]
}

export const useCommitteesStore = defineStore('committees', {
    state: (): State => ({
        committee: {
            name: '',
            id: '',
            description: ''
        },
        committees: []
    }),
    actions: {
        async getCommittee(committeeId: string) {
            await axios.get(route('tenant.committees.show', committeeId)).then((res) => {
                this.committee = res.data.committee
            })
        },

        async getCommitteeDetails(committeeId: string) {
            const { data } = await axios.get(route('tenant.committees.details', committeeId))

            this.committee = data.committee
        },

        async getCommittees() {
            if (this.committees.length > 0) {
                return
            }

            const { data: committees } = await axios.get(route('tenant.list.committees'))

            this.committees = committees
        },

        findCommitteeById(id: string) {
            return this.committees.find((committee) => committee.id === id)
        }
    }
})
