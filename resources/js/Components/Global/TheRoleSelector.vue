<script lang="ts" setup>
import { useRolesStore } from '@/stores/roles'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const roles = defineModel<string[]>('roles')

const rolesStore = useRolesStore()

onMounted(async () => {
    await rolesStore.getRoles()
})
</script>

<template>
    <base-list-box
        v-model="roles"
        :model-value="roles"
        :options="rolesStore.roles"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_role') })"
        label-key="name"
        multiple
        value-key="uuid"
    ></base-list-box>
</template>
