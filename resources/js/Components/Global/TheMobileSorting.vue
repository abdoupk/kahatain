<script lang="ts" setup>
import { ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BasePopover from '@/Components/Base/headless/Popover/BasePopover.vue'
import BasePopoverButton from '@/Components/Base/headless/Popover/BasePopoverButton.vue'
import BasePopoverPanel from '@/Components/Base/headless/Popover/BasePopoverPanel.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    sortableFields: { value: string; label: string }[]
}>()

const emit = defineEmits(['sort'])

const field = ref<string>('')

const direction = ref<string>('')

const handleSort = (close: () => void) => {
    if (field.value && direction.value) {
        emit('sort', { field: field.value, direction: direction.value })
    }

    close()
}
</script>

<template>
    <base-popover v-slot="{ close }" class="!z-50 inline-block text-center">
        <base-popover-button
            :as="BaseButton"
            class="me-2 flex content-center items-center whitespace-nowrap"
            variant="outline-secondary"
        >
            <svg-loader class="fill-primary dark:fill-slate-400" name="icon-arrow-down-arrow-up"></svg-loader>
        </base-popover-button>

        <base-popover-panel placement="bottom-start">
            <div class="w-56 p-2">
                <form @submit.prevent="() => handleSort(close)">
                    <div>
                        <div class="text-start ltr:text-xs rtl:text-sm rtl:font-semibold">
                            {{ $t('fields') }}
                        </div>

                        <base-form-select v-model="field" class="mt-1.5">
                            <option value="">{{ $t('filters.select_an_option') }}</option>

                            <option v-for="field in sortableFields" :key="field.value" :value="field.value">
                                {{ $t(field.label) }}
                            </option>
                        </base-form-select>
                    </div>

                    <div class="mt-3">
                        <div class="text-start ltr:text-xs rtl:text-sm rtl:font-semibold">
                            {{ $t('the_sort') }}
                        </div>

                        <base-form-select v-model="direction" class="mt-1.5">
                            <option value="">{{ $t('filters.select_an_option') }}</option>

                            <option value="asc">{{ $t('asc') }}</option>

                            <option value="desc">{{ $t('desc') }}</option>
                        </base-form-select>
                    </div>

                    <div class="mt-3 flex items-center">
                        <base-button class="ms-2 w-32" type="submit" variant="primary">
                            {{ $t('sort') }}
                        </base-button>
                    </div>
                </form>
            </div>
        </base-popover-panel>
    </base-popover>
</template>
