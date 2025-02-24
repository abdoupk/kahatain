<script lang="ts" setup>
import type { CityType, Commune } from '@/types/types'

import { useCityStore } from '@/stores/city'
import { onMounted } from 'vue'

import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const props = defineProps<{
    errorMessage?: string | string[]
    city: CityType
}>()

const commune = defineModel<Commune>('commune')

const cityStore = useCityStore()

onMounted(async () => {
    if (props.city) {
        await cityStore.fetchCommunes(props.city.daira_name, props.city.wilaya_code)

        cityStore.getCommune(props.city.id)

        commune.value = cityStore.commune?.id
    }
})
</script>

<template>
    <div>
        <base-form-label for="communes">
            {{ $t('commune') }}
        </base-form-label>

        <base-list-box
            id="communes"
            v-model="commune"
            :model-value="commune"
            :options="cityStore.communes"
            :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('commune') })"
            label-key="commune_name"
            value-key="id"
        ></base-list-box>

        <base-input-error v-if="errorMessage">
            <div class="mt-2 text-danger">
                {{ Array.isArray(errorMessage) ? errorMessage[0] : errorMessage }}
            </div>
        </base-input-error>
    </div>
</template>
