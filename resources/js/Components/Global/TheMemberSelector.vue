<script lang="ts" setup>
import { useMembersStore } from '@/stores/members'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const member = defineModel<string | string[]>('member', { default: '' })

const membersStore = useMembersStore()

onMounted(async () => {
    await membersStore.getMembers()
})
</script>

<template>
    <base-list-box
        v-model="member"
        :model-value="member"
        :options="membersStore.members"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_member') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
