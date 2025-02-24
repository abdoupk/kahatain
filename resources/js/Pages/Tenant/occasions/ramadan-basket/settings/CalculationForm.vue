<script lang="ts" setup>
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { Form } from 'laravel-precognition-vue/dist/types'
import { defineAsyncComponent } from 'vue'

import { $t } from '@/utils/i18n'

const TheRamadanBasketCategories = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/ramadan-basket/settings/TheRamadanBasketCategories.vue')
)

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const BaseInputGroup = defineAsyncComponent(() => import('@/Components/Base/form/InputGroup/BaseInputGroup.vue'))

const BaseInputGroupText = defineAsyncComponent(
    () => import('@/Components/Base/form/InputGroup/BaseInputGroupText.vue')
)

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

defineProps<{
    form: Form<unknown>
}>()

const sponsorshipsStore = useSponsorshipsStore()

const removeInterval = (index: number) => {
    if (index === 0) return

    sponsorshipsStore.ramadan_sponsorship.categories.splice(index, 1)
}

const addInterval = () => {
    sponsorshipsStore.ramadan_sponsorship.categories.push({
        category: '',
        maximum: 0,
        minimum: 0
    })
}
</script>

<template>
    <!-- Begin: Threshold-->
    <div class="col-span-12 sm:col-span-4">
        <base-form-label htmlFor="threshold">
            {{ $t('settings.threshold') }}
        </base-form-label>

        <base-input-group>
            <base-form-input
                id="threshold"
                v-model="sponsorshipsStore.ramadan_sponsorship.threshold"
                :placeholder="
                    $t('auth.placeholders.tomselect', {
                        attribute: $t('settings.threshold')
                    })
                "
                type="number"
                @change="form.validate('threshold')"
            ></base-form-input>

            <base-input-group-text>
                {{ $t('DA') }}
            </base-input-group-text>
        </base-input-group>

        <div v-if="form.errors?.threshold" class="mt-2">
            <base-input-error :message="form.errors.threshold"></base-input-error>
        </div>
    </div>
    <!-- End: Threshold-->

    <!-- Begin: Categories for calculation of sponsorship rate-->
    <div class="col-span-12 grid gap-4">
        <div class="mt-1.5 text-base">{{ $t('settings.categories_for_categorise_ramadan_baskets') }}</div>

        <the-ramadan-basket-categories
            v-for="(category, index) in sponsorshipsStore.ramadan_sponsorship.categories"
            :key="index"
            v-model:category="category.category"
            v-model:maximum="category.maximum"
            v-model:minimum="category.minimum"
            :form
            :index
            @remove-interval="removeInterval(index)"
        ></the-ramadan-basket-categories>
    </div>

    <div class="col-span-12 flex items-center justify-center">
        <base-button
            class="mx-auto mt-3 block w-1/2 border-dashed dark:text-slate-500"
            type="button"
            variant="outline-primary"
            @click.prevent="addInterval"
        >
            <svg-loader class="inline fill-primary dark:fill-slate-500" name="icon-plus"></svg-loader>

            {{ $t('add_category') }}
        </base-button>
    </div>
    <!-- End: Categories for calculation of sponsorship rate-->
</template>
