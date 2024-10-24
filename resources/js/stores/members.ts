import type { CreateMemberForm, MembersType, Role } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    member: CreateMemberForm & {
        id?: string
        formatted_roles?: {
            id: string
            name: string
        }[]
        branch?: {
            id: string
            name: string
        }
        zone?: {
            id: string
            name: string
        }
        name?: string
        readable_created_at?: string
        creator?: {
            id: string
            name: string
        }
        readable_roles?: string
    }
    members: MembersType[]
}

export const useMembersStore = defineStore('members', {
    state: (): State => ({
        member: {
            id: '',
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            zone_id: '',
            qualification: '',
            gender: 'male',
            roles: [''],
            branch_id: '',
            password: '',
            password_confirmation: '',
            address: '',
            location: {
                lat: null,
                lng: null
            },
            function: '',
            workplace: '',
            competences: [],
            readable_roles: '',
            academic_level_id: null
        },
        members: []
    }),
    actions: {
        async getMember(memberId: string) {
            const {
                data: { member }
            } = await axios.get(`members/show/${memberId}`)

            this.member = { ...member }

            this.member.formatted_roles = member.roles

            this.member.roles = member.roles.map((role: Role) => role.uuid)

            this.member.branch_id = member.branch?.id

            this.member.branch = { ...member.branch }

            this.member.zone_id = member.zone?.id

            this.member.zone = { ...member.zone }
        },

        async getMembers() {
            if (this.members.length) {
                return
            }

            const { data: members } = await axios.get(route('tenant.list.members'))

            this.members = members
        },

        async searchMembers(search: string) {
            const { data: members } = await axios.get(route('tenant.members.search' , { search }))

            return members
        },

        async getMemberDetails(memberId: string) {
            const { data } = await axios.get(route('tenant.members.details', memberId))

            this.member = data.member
        },

        findMembersByIds(ids: string[] | string) {
            if (typeof ids === 'string') {
                return this.members.filter((member) => member.id === ids)
            }

            return this.members.filter((member) => ids.includes(member.id))
        }
    }
})
