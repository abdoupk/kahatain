<script lang="ts" setup>
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { Form } from 'laravel-precognition-vue/dist/types'
import { defineAsyncComponent } from 'vue'

import { $t } from '@/utils/i18n'

defineProps<{
    form: Form<unknown>
}>()

const TheSponsorshipRateCategories = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/monthly-sponsorship/settings/TheSponsorshipRateCategories.vue')
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

// Get the sponsorships store
const sponsorshipsStore = useSponsorshipsStore()

const addInterval = () => {
    sponsorshipsStore.monthly_sponsorship.categories.push({
        minimum: null,
        maximum: null,
        value: null
    })
}

const removeInterval = (index: number) => {
    if (index === 0) return

    sponsorshipsStore.monthly_sponsorship.categories.splice(index, 1)
}
</script>

<template>
    <!-- Begin: University scholarship bachelor-->
    <div class="col-span-12 sm:col-span-4">
        <base-form-label htmlFor="university_scholarship_bachelor">
            {{ $t('validation.attributes.university_scholarship_bachelor') }}
        </base-form-label>

        <base-input-group>
            <base-form-input
                id="university_scholarship_bachelor"
                ref="firstInputRef"
                v-model="sponsorshipsStore.monthly_sponsorship.university_scholarship_bachelor"
                :placeholder="
                    $t('auth.placeholders.tomselect', {
                        attribute: $t('validation.attributes.university_scholarship_bachelor')
                    })
                "
                type="number"
                @change="form.validate('university_scholarship_bachelor')"
            ></base-form-input>

            <base-input-group-text>
                {{ $t('DA') }}
            </base-input-group-text>
        </base-input-group>

        <div v-if="form.errors?.university_scholarship_bachelor" class="mt-2">
            <base-input-error :message="form.errors.university_scholarship_bachelor"></base-input-error>
        </div>
    </div>
    <!-- End: University scholarship bachelor-->

    <!-- Begin: University scholarship Master 1-->
    <div class="col-span-12 sm:col-span-4">
        <base-form-label htmlFor="university_scholarship_master_one">
            {{ $t('validation.attributes.university_scholarship_master_one') }}
        </base-form-label>

        <base-input-group>
            <base-form-input
                id="university_scholarship_master_one"
                v-model="sponsorshipsStore.monthly_sponsorship.university_scholarship_master_one"
                :placeholder="
                    $t('auth.placeholders.tomselect', {
                        attribute: $t('validation.attributes.university_scholarship_master_one')
                    })
                "
                type="number"
                @change="form.validate('university_scholarship_master_one')"
            ></base-form-input>

            <base-input-group-text>
                {{ $t('DA') }}
            </base-input-group-text>
        </base-input-group>

        <div v-if="form.errors?.university_scholarship_master_one" class="mt-2">
            <base-input-error :message="form.errors.university_scholarship_master_one"></base-input-error>
        </div>
    </div>
    <!-- End: University scholarship Master 1-->

    <!-- Begin: University scholarship Master 2-->
    <div class="col-span-12 sm:col-span-4">
        <base-form-label htmlFor="university_scholarship_master_two">
            {{ $t('validation.attributes.university_scholarship_master_two') }}
        </base-form-label>

        <base-input-group>
            <base-form-input
                id="university_scholarship_master_two"
                v-model="sponsorshipsStore.monthly_sponsorship.university_scholarship_master_two"
                :placeholder="
                    $t('auth.placeholders.tomselect', {
                        attribute: $t('validation.attributes.university_scholarship_master_two')
                    })
                "
                type="number"
                @change="form.validate('university_scholarship_master_two')"
            ></base-form-input>

            <base-input-group-text>
                {{ $t('DA') }}
            </base-input-group-text>
        </base-input-group>

        <div v-if="form.errors?.university_scholarship_master_two" class="mt-2">
            <base-input-error :message="form.errors.university_scholarship_master_two"></base-input-error>
        </div>
    </div>
    <!-- End: University scholarship Master 2-->

    <!-- Begin: University scholarship Doctorate-->
    <div class="col-span-12 sm:col-span-4">
        <base-form-label htmlFor="university_scholarship_doctorate">
            {{ $t('validation.attributes.university_scholarship_doctorate') }}
        </base-form-label>

        <base-input-group>
            <base-form-input
                id="university_scholarship_doctorate"
                v-model="sponsorshipsStore.monthly_sponsorship.university_scholarship_doctorate"
                :placeholder="
                    $t('auth.placeholders.tomselect', {
                        attribute: $t('validation.attributes.university_scholarship_doctorate')
                    })
                "
                type="number"
                @change="form.validate('university_scholarship_doctorate')"
            ></base-form-input>

            <base-input-group-text>
                {{ $t('DA') }}
            </base-input-group-text>
        </base-input-group>

        <div v-if="form.errors?.university_scholarship_doctorate" class="mt-2">
            <base-input-error :message="form.errors.university_scholarship_doctorate"></base-input-error>
        </div>
    </div>
    <!-- End: University scholarship Doctorate-->

    <!-- Begin: Unemployment benefit-->
    <div class="col-span-12 sm:col-span-4">
        <base-form-label htmlFor="unemployment_benefit">
            {{ $t('settings.unemployment_benefit') }}
        </base-form-label>

        <base-input-group>
            <base-form-input
                id="unemployment_benefit"
                v-model="sponsorshipsStore.monthly_sponsorship.unemployment_benefit"
                :placeholder="
                    $t('auth.placeholders.tomselect', {
                        attribute: $t('settings.unemployment_benefit')
                    })
                "
                type="number"
                @change="form.validate('unemployment_benefit')"
            ></base-form-input>

            <base-input-group-text>
                {{ $t('DA') }}
            </base-input-group-text>
        </base-input-group>

        <div v-if="form.errors?.unemployment_benefit" class="mt-2">
            <base-input-error :message="form.errors.unemployment_benefit"></base-input-error>
        </div>
    </div>
    <!-- End: Unemployment benefit-->

    <!-- Begin: Threshold-->
    <div class="col-span-12 sm:col-span-4">
        <base-form-label htmlFor="threshold">
            {{ $t('settings.threshold') }}
        </base-form-label>

        <base-input-group>
            <base-form-input
                id="threshold"
                v-model="sponsorshipsStore.monthly_sponsorship.threshold"
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

    <!-- Begin: Association basket value-->
    <div class="col-span-12 sm:col-span-4">
        <base-form-label htmlFor="association_basket_value">
            {{ $t('validation.attributes.association_basket_value') }}
        </base-form-label>

        <base-input-group>
            <base-form-input
                id="association_basket_value"
                v-model="sponsorshipsStore.monthly_sponsorship.association_basket_value"
                :placeholder="
                    $t('auth.placeholders.tomselect', {
                        attribute: $t('validation.attributes.association_basket_value')
                    })
                "
                type="number"
                @change="form.validate('association_basket_value')"
            ></base-form-input>

            <base-input-group-text>
                {{ $t('DA') }}
            </base-input-group-text>
        </base-input-group>

        <div v-if="form.errors?.association_basket_value" class="mt-2">
            <base-input-error :message="form.errors.association_basket_value"></base-input-error>
        </div>
    </div>
    <!-- End: Association basket value-->

    <!-- Begin: Categories for calculation of sponsorship rate-->
    <div class="col-span-12 grid gap-4">
        <div class="mt-1.5 text-base">
            {{ $t('settings.categories_for_calculation_of_sponsorship_rate') }}
        </div>

        <the-sponsorship-rate-categories
            v-for="(category, index) in sponsorshipsStore.monthly_sponsorship.categories"
            :key="index"
            v-model:maximum="category.maximum"
            v-model:minimum="category.minimum"
            v-model:value="category.value"
            :form
            :index
            @remove-interval="removeInterval(index)"
        ></the-sponsorship-rate-categories>
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
