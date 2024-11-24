<script lang="ts" setup>
import { EidSuitOrphansResource } from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'

import { debounce } from '@/utils/helper'

const props = defineProps<{
    orphan: EidSuitOrphansResource
    field: 'clothes_shop_phone_number' | 'clothes_shop_name' | 'shoes_shop_name' | 'shoes_shop_phone_number' | 'note'
}>()

const orphan = ref(props.orphan)

orphan.value.orphan.edit = {
    clothes_shop_name: false,
    clothes_shop_phone_number: false,
    shoes_shop_name: false,
    shoes_shop_phone_number: false,
    note: false
}

const selectedOrphan = ref({
    orphan_id: ''
})

const updateInput = (event: Event) => {
    if (event?.target.value) {
        if (selectedOrphan.value.orphan_id !== orphan.value.orphan.id) {
            selectedOrphan.value = {}
        }

        selectedOrphan.value.orphan_id = orphan.value.orphan.id

        selectedOrphan.value[props.field] = (event.target as HTMLInputElement).value

        orphan.value.eid_suit[props.field] = (event.target as HTMLInputElement).value

        submit()
    }

    orphan.value.orphan.edit[props.field] = false
}

const form = useForm('get', route('tenant.orphans.edit', selectedOrphan.value.orphan_id), {
    ...selectedOrphan.value
})

const submit = debounce(() => {
    form.submit({
        onSuccess() {
            console.log('success')
        }
    })
}, 2000)

// Const handleSelectDesignatedMember = (orphan_id: string, event: { id: string; name: string }) => {
//     If (event.id) {
//         SelectedOrphan.value.orphan_id = orphan_id
//
//         SelectedOrphan.value.designated_member = event
//     }
//
//     Submit()
// }

const handleSelectCell = () => {
    orphan.value.orphan.edit[props.field] = true

    nextTick(() => {
        const input: HTMLInputElement = document.getElementById(`${props.field}_${orphan.value.orphan.id}`)

        input?.focus()

        input.value = orphan.value.eid_suit[props.field]
    })
}
</script>

<template>
    <the-table-td class="text-center">
        <span v-if="!orphan.orphan?.edit[field]" class="block w-32 cursor-pointer truncate" @click="handleSelectCell">
            {{ orphan.eid_suit[field] ?? '-' }}
        </span>

        <base-form-input
            v-else
            :id="`${field}_${orphan.orphan.id}`"
            class="w-32"
            @keydown.enter.prevent="updateInput($event)"
            @blur.prevent="updateInput($event)"
        ></base-form-input>
    </the-table-td>
</template>
