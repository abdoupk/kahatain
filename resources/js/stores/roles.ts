import type { CreateRoleForm } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    role: CreateRoleForm & { uuid: string }
    roles: { uuid: string; name: string }[]
}

export const useRolesStore = defineStore('roles', {
    state: (): State => ({
        roles: [],
        role: {
            id: '',
            permissions: {},
            name: ''
        }
    }),
    actions: {
        async getRoles() {
            if (this.roles.length > 0) {
                return
            }

            const response = await axios.get(route('tenant.list.roles'))

            this.roles = response.data
        },

        async getRole(roleId: string) {
            const {
                data: { role }
            } = await axios.get(`roles/show/${roleId}`)

            this.role = role
        }
    }
})
