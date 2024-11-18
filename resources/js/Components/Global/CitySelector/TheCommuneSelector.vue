<script lang="ts" setup>
import type { CityType, Commune } from '@/types/types'

import { useCityStore } from '@/stores/city'
import { onMounted, ref, watch } from 'vue'

import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const props = defineProps<{
    errorMessage?: string | string[]
    city: CityType
}>()

const commune = defineModel<Commune>('commune')

const selectedCommune = ref<Commune>()

const cityStore = useCityStore()

onMounted(async () => {
    if (props.city) {
        await cityStore.fetchCommunes(props.city.daira_name, props.city.wilaya_code)

        cityStore.getCommune(props.city.id)

        selectedCommune.value = cityStore.commune
    }
})

const handleChange = () => {
    commune.value = selectedCommune.value
}

watch(
    () => commune.value,
    (value) => {
        selectedCommune.value = value
    }
)
</script>

<template>
    <div>
        <base-form-label for="communes">
            {{ $t('commune') }}
        </base-form-label>

        <div>
            <!-- @vue-ignore -->
            <base-vue-select
                id="communes"
                v-model:value="selectedCommune"
                :options="cityStore.communes"
                :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('commune') })"
                class="tom-select w-full"
                label="commune_name"
                track-by="id"
                @update:value="handleChange"
            ></base-vue-select>
        </div>

        <base-input-error v-if="errorMessage">
            <div class="mt-2 text-danger">
                {{ Array.isArray(errorMessage) ? errorMessage[0] : errorMessage }}
            </div>
        </base-input-error>
    </div>
</template>
