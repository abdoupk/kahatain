<script lang="ts" setup>
import type { CityType, Wilaya } from '@/types/types'

import { useCityStore } from '@/stores/city'
import { onMounted, ref } from 'vue'

import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { isEmpty } from '@/utils/helper'

const props = defineProps<{
    city: CityType
}>()

const cityStore = useCityStore()

const selectedWilaya = ref<Wilaya>()

const emit = defineEmits(['update:modelValue'])

onMounted(async () => {
    await cityStore.fetchWilayas()

    if (!isEmpty(props.city)) selectedWilaya.value = props.city
})

const handleChange = async () => {
    cityStore.communes = []

    await cityStore.fetchDairas(selectedWilaya.value?.wilaya_code)

    cityStore.getWilaya(selectedWilaya.value?.wilaya_code)

    emit('update:modelValue')
}
</script>

<template>
    <div>
        <base-form-label for="wilayas">
            {{ $t('wilaya') }}
        </base-form-label>

        <div>
            <!-- @vue-ignore -->
            <base-vue-select
                id="wilayas"
                v-model:value="selectedWilaya"
                :options="cityStore.wilayas"
                :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('wilaya') })"
                class="h-full w-full"
                label="wilaya_name"
                track-by="wilaya_code"
                @update:value="handleChange"
            >
            </base-vue-select>
        </div>
    </div>
</template>
