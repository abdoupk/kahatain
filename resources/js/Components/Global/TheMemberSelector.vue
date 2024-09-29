<script lang="ts" setup>
import type { MemberType, MembersType } from '@/types/types'

import { useMembersStore } from '@/stores/members'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const member = defineModel<string | string[]>('member', { default: '' })

const selectedMember = ref<MembersType | string | undefined>('')

const membersStore = useMembersStore()

const handleUpdate = (value: MembersType | MemberType) => {
    if (Array.isArray(value)) {
        member.value = value.map((member) => member.id)
    } else member.value = value.id
}

onMounted(async () => {
    await membersStore.getMembers()

    selectedMember.value = membersStore.findMembersByIds(member.value)
})

watch(
    () => member.value,
    () => {
        selectedMember.value = membersStore.findMembersByIds(member.value)
    }
)
</script>

<template>
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedMember"
        :options="membersStore.members"
        label="name"
        track-by="id"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
