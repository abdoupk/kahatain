<script lang="ts" setup>
import { EidSuitOrphansResource } from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import MembersFilterDropDown from '@/Components/Global/filters/MembersFilterDropDown.vue'

const props = defineProps<{
    orphan: EidSuitOrphansResource
}>()

const orphan = ref(props.orphan)

const emit = defineEmits(['showSuccessNotification'])

const handleSelectCell = () => {
    orphan.value.orphan.edit.member = true

    nextTick(() => {
        document.getElementById(`designated_member_${orphan.value.orphan.id}`)?.querySelector('input')?.focus()
    })
}

const handleSelectDesignatedMember = (event: { id: string; name: string }) => {
    if (event.id) {
        useForm('patch', route('tenant.occasions.eid-suit.save-infos', orphan.value.orphan.id), {
            orphan_id: orphan.value.orphan.id,
            user_id: event.id
        }).submit({
            onSuccess() {
                orphan.value.orphan.edit.member = false

                orphan.value.eid_suit.member = event

                emit('showSuccessNotification')
            }
        })
    }
}
</script>

<template>
    <the-table-td>
        <div
            v-if="orphan.eid_suit?.member.id && !orphan.orphan.edit?.member"
            class="block w-40 cursor-pointer truncate text-center"
            @click="handleSelectCell"
        >
            {{ orphan.eid_suit?.member.name }}
        </div>

        <span
            v-else-if="!orphan.eid_suit?.member.id && !orphan.orphan.edit?.member"
            class="block w-40 cursor-pointer text-center"
            @click="handleSelectCell"
        >
            -
        </span>

        <members-filter-drop-down
            v-else
            :id="`designated_member_${orphan.orphan.id}`"
            :value="orphan.eid_suit.member"
            class="!mt-0 !w-40"
            @focusout.prevent="orphan.orphan.edit.member = false"
            @update:value="handleSelectDesignatedMember"
        ></members-filter-drop-down>
    </the-table-td>
</template>
