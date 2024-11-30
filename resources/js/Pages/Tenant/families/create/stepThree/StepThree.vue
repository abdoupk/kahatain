<script lang="ts" setup>
import type { CreateFamilyStepProps } from '@/types/types'

import { useCreateFamilyStore } from '@/stores/create-family'

import TheOrphans from '@/Pages/Tenant/families/create/stepThree/TheOrphans.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

import { $t } from '@/utils/i18n'

defineProps<CreateFamilyStepProps>()

const createFamilyStore = useCreateFamilyStore()

const addOrphan = () => {
    createFamilyStore.family.orphans.push({
        baby_milk_quantity: 0,
        baby_milk_type: '',
        diapers_quantity: 0,
        diapers_type: '',
        gender: 'male',
        income: null,
        academic_level_id: null,
        vocational_training_id: null,
        birth_date: '',
        family_status: '',
        health_status: '',
        last_name: '',
        note: '',
        pants_size: '',
        shirt_size: '',
        shoes_size: '',
        is_unemployed: false,
        is_handicapped: false,
        first_name: ''
    })
}
</script>

<template>
    <div
        v-if="createFamilyStore.current_step === 3"
        class="mt-10 border-t border-slate-200/60 px-5 pt-10 dark:border-darkmode-400 sm:px-20"
    >
        <div class="mb-6 hidden text-lg font-medium lg:block">
            {{ $t('families.create_family.stepThree') }}
        </div>

        <the-orphans :form></the-orphans>

        <base-button
            class="mx-auto mt-4 block w-1/2 border-dashed dark:text-slate-500"
            data-test="add_orphan"
            type="button"
            variant="outline-primary"
            @click="addOrphan"
        >
            <svg-loader class="inline fill-primary dark:fill-slate-500" name="icon-plus"></svg-loader>

            {{ $t('add_new_orphan') }}
        </base-button>

        <slot></slot>
    </div>
</template>
