<script lang="ts" setup>
import type { CityType } from '@/types/types'

import TheCommuneSelector from '@/Components/Global/CitySelector/TheCommuneSelector.vue'
import TheDairaSelector from '@/Components/Global/CitySelector/TheDairaSelector.vue'
import TheWilayaSelector from '@/Components/Global/CitySelector/TheWilayaSelector.vue'

const daira = defineModel('daira')

const commune = defineModel('commune')

const cityId = defineModel('cityId')

defineProps<{
    errorMessage?: string | string[]
    city: CityType
}>()
</script>

<template>
    <div class="grid w-full flex-1 grid-cols-1 gap-4 gap-y-5 lg:grid-cols-3">
        <the-wilaya-selector
            :city
            @update:model-value="
                () => {
                    commune = ''

                    daira = ''

                    cityId = ''
                }
            "
        ></the-wilaya-selector>

        <the-daira-selector
            :city
            @update:model-value="
                () => {
                    commune = ''

                    cityId = ''
                }
            "
        ></the-daira-selector>

        <the-commune-selector
            v-model:commune="commune"
            :city
            :errorMessage
            @update:commune="cityId = $event"
        ></the-commune-selector>
    </div>
</template>
