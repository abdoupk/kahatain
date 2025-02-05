<script lang="ts" setup>
import { EidSuitOrphansResource } from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { computed, nextTick, ref } from 'vue'

import RowCombobox from '@/Pages/Tenant/occasions/eid-suit/RowCombobox.vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'

const props = defineProps<{
    orphan: EidSuitOrphansResource
    field: 'clothes_shop_phone_number' | 'clothes_shop_name' | 'shoes_shop_name' | 'shoes_shop_phone_number' | 'note'
    loadOptions?: (results: { id: string; name: string }[]) => void
    view?: 'desktop' | 'mobile'
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['showSuccessNotification', 'selectOrphan', 'deselectOrphan'])

const orphan = ref(props.orphan)

const hasError = ref(false)

const data = ref({
    orphan_id: props.orphan.orphan.id
})

const phoneNumberRegex = /^(0[5-7]\d{8})$/

orphan.value.orphan.edit = {
    clothes_shop_name: false,
    clothes_shop_phone_number: false,
    shoes_shop_name: false,
    shoes_shop_phone_number: false,
    note: false
}

const submit = () => {
    useForm('patch', route('tenant.occasions.eid-suit.save-infos', props.orphan.orphan.id), data.value).submit({
        onSuccess() {
            emit('showSuccessNotification')
        }
    })
}

const handleSubmit = ($event) => {
    if (props.field === 'note') {
        data.value[props.field] = $event.target.value

        orphan.value.eid_suit[props.field] = $event.target.value
    } else {
        data.value[props.field] = $event.name

        orphan.value.eid_suit[props.field] = $event.name
    }

    if (
        props.field === 'clothes_shop_phone_number' ||
        (props.field === 'shoes_shop_phone_number' && data.value[props.field]?.length < 10)
    ) {
        hasError.value = true
    }

    if (validate.value) {
        orphan.value.orphan.edit[props.field] = false

        submit()
    }
}

const validate = computed(() => {
    if (props.field === 'clothes_shop_phone_number' || props.field === 'shoes_shop_phone_number') {
        return phoneNumberRegex.test(data.value[props.field])
    }

    return data.value[props.field]?.length <= 255
})

const handleSelectCell = () => {
    orphan.value.orphan.edit[props.field] = true

    emit('selectOrphan')

    nextTick(() => {
        if (props.field === 'note') {
            document.getElementById(`${props.field}_${orphan.value.orphan.id}`)?.focus()
        } else document.getElementById(`${props.field}_${orphan.value.orphan.id}`)?.querySelector('input')?.focus()
    })
}

const maxLength = computed(() => {
    if (props.field === 'clothes_shop_phone_number' || props.field === 'shoes_shop_phone_number') {
        return 10
    }

    return 255
})

const handleFocusOut = () => {
    if (!validate.value) {
        orphan.value.eid_suit[props.field] = null
    }

    orphan.value.orphan.edit[props.field] = false

    emit('deselectOrphan')
}
</script>

<template>
    <template v-if="view === 'mobile'">
        <row-combobox
            v-if="field !== 'note'"
            :id="`${field}_${orphan.orphan.id}`"
            :has-error
            :load-options
            :max-length
            :model-value="{ id: orphan.eid_suit[field] ?? '', name: orphan.eid_suit[field] ?? '' }"
            :options="[]"
            class="ms-4 w-1/2"
            :class="$attrs.class"
            size="sm"
            @focusin="emit('selectOrphan')"
            @focusout.prevent="handleFocusOut"
            @update:model-value="handleSubmit"
        ></row-combobox>

        <base-form-text-area
            v-else
            :id="`note_${orphan.orphan.id}`"
            v-model.lazy="orphan.eid_suit.note"
            rows="4"
            @focusin="emit('selectOrphan')"
            @focusout="emit('deselectOrphan')"
            @keydown.enter="handleSubmit"
            @focusout.prevent="handleFocusOut"
        ></base-form-text-area>
    </template>

    <template v-else>
        <the-table-td v-if="field !== 'note'" class="text-center">
            <span
                v-if="!orphan.orphan?.edit[field]"
                class="block w-32 cursor-pointer truncate"
                @click="handleSelectCell"
            >
                {{ orphan.eid_suit[field] ?? '-' }}
            </span>

            <row-combobox
                v-else
                :id="`${field}_${orphan.orphan.id}`"
                :has-error
                :load-options
                :max-length
                :model-value="{ id: orphan.eid_suit[field] ?? '', name: orphan.eid_suit[field] ?? '' }"
                :options="[]"
                class="!mt-0 w-32"
                @focusout.prevent="handleFocusOut"
                @update:model-value="handleSubmit"
            ></row-combobox>
        </the-table-td>

        <the-table-td v-else class="text-center">
            <span v-if="!orphan.orphan?.edit.note" class="block w-32 cursor-pointer truncate" @click="handleSelectCell">
                {{ orphan.eid_suit.note ?? '-' }}
            </span>

            <base-form-input
                v-else
                :id="`note_${orphan.orphan.id}`"
                v-model.lazy="orphan.eid_suit.note"
                class="!mt-0 w-32"
                @focusout.prevent="handleFocusOut"
                @keydown.enter="handleSubmit"
            ></base-form-input>
        </the-table-td>
    </template>
</template>
