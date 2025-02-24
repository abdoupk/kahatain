<script lang="ts" setup>
import type { CreateFamilyForm } from '@/types/types'

import { useCreateFamilyStore } from '@/stores/create-family'
import type { Form } from 'laravel-precognition-vue/dist/types'
import { onMounted, ref } from 'vue'

import BaseAlert from '@/Components/Base/Alert/BaseAlert.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t } from '@/utils/i18n'

export type HousingType = 'independent' | 'with_family' | 'tenant' | 'inheritance' | 'other'

defineProps<{ form: Form<CreateFamilyForm> }>()

const createFamilyStore = useCreateFamilyStore()

const items = ref<Record<HousingType, boolean>>({
    independent: false,
    with_family: false,
    tenant: false,
    inheritance: false,
    other: false
})

const toggle = (key: HousingType, value?: string | number | boolean) => {
    createFamilyStore.family.housing.housing_type.name = key

    items.value[key] = !items.value[key]

    Object.keys(items.value)
        .filter((item) => item !== key)
        .forEach((item) => {
            items.value[item as HousingType] = false
        })

    value
        ? (createFamilyStore.family.housing.housing_type.value = value)
        : (createFamilyStore.family.housing.housing_type.value = null)
}

const setValue = (event: Event) => {
    createFamilyStore.family.housing.housing_type.value = (event.target as HTMLInputElement).value
}

onMounted(() => {
    document.getElementById('independent')?.focus()

    items.value[createFamilyStore.family.housing.housing_type.name] = true
})
</script>

<template>
    <transition>
        <base-alert
            v-if="
                form.invalid(
                    // @ts-ignore
                    'housing.housing_type.value'
                ) ||
                form.invalid(
                    // @ts-ignore
                    'housing_type.value'
                )
            "
            class="mb-2 flex w-full items-center sm:w-1/2"
            variant="soft-danger"
        >
            <svg-loader class="me-2 h-6 w-6 fill-current" name="icon-circle-exclamation"></svg-loader>
            {{
                // @ts-ignore
                form.errors['housing.housing_type.value'] ||
                // @ts-ignore
                form.errors['housing_type.value']
            }}
        </base-alert>
    </transition>

    <div class="intro-x mt-6">
        <div class="flex gap-16">
            <base-form-switch class="text-lg">
                <!-- @vue-ignore -->
                <base-form-switch-input
                    id="independent"
                    :checked="items.independent"
                    type="checkbox"
                    @change="(event) => toggle('independent', event.target.checked)"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="independent">
                    {{ $t('housing.label.independent') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
    </div>

    <div class="intro-x mt-6">
        <div class="flex gap-16">
            <base-form-switch class="text-lg">
                <!-- @vue-ignore -->
                <base-form-switch-input
                    id="with_family"
                    :checked="items.with_family"
                    type="checkbox"
                    @change="(event) => toggle('with_family', event.target.checked)"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="with_family">
                    {{ $t('housing.label.with_family') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
    </div>

    <div class="intro-x mt-6">
        <div class="mt-6 flex flex-col md:flex-row md:gap-16">
            <base-form-switch class="w-full text-lg md:w-1/2">
                <base-form-switch-input
                    id="inheritance"
                    :checked="items.inheritance"
                    type="checkbox"
                    @change="toggle('inheritance')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="inheritance">
                    {{ $t('housing.label.inheritance') }}
                </base-form-switch-label>
            </base-form-switch>

            <div class="mt-2 w-full md:mt-0">
                <base-form-input
                    :disabled="
                        createFamilyStore.family.housing.housing_type.name !== 'inheritance' || !items.inheritance
                    "
                    :placeholder="$t('housing.placeholders.inheritance')"
                    :value="
                        createFamilyStore.family.housing.housing_type.name === 'inheritance'
                            ? createFamilyStore.family.housing.housing_type.value
                            : null
                    "
                    class="w-full md:w-3/4"
                    type="number"
                    @input="setValue"
                ></base-form-input>
            </div>
        </div>
    </div>

    <div class="intro-x mt-6">
        <div class="mt-6 flex flex-col md:flex-row md:gap-16">
            <base-form-switch class="w-full text-lg md:w-1/2">
                <base-form-switch-input
                    id="tenant"
                    :checked="items.tenant"
                    type="checkbox"
                    @change="toggle('tenant')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="tenant">
                    {{ $t('housing.label.tenant') }}
                </base-form-switch-label>
            </base-form-switch>

            <div class="mt-2 w-full md:mt-0">
                <base-input-group class="w-5/6">
                    <!-- @vue-ignore -->
                    <base-form-input
                        :disabled="createFamilyStore.family.housing.housing_type.name !== 'tenant' || !items.tenant"
                        :placeholder="$t('housing.placeholders.tenant')"
                        :value="
                            createFamilyStore.family.housing.housing_type.name === 'tenant'
                                ? createFamilyStore.family.housing.housing_type.value
                                : null
                        "
                        class="w-full md:w-3/4"
                        type="text"
                        @input="setValue"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-input-group-text>
                        {{ $t('DA') }}
                    </base-input-group-text>
                </base-input-group>
            </div>
        </div>
    </div>

    <div class="intro-x mt-6">
        <div class="mt-6 flex flex-col md:flex-row md:gap-16">
            <base-form-switch class="w-full text-lg md:w-1/2">
                <base-form-switch-input
                    id="other"
                    :checked="items.other"
                    type="checkbox"
                    @change="toggle('other')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="other">
                    {{ $t('housing.label.other') }}
                </base-form-switch-label>
            </base-form-switch>

            <div class="mt-2 w-full md:mt-0">
                <base-form-input
                    :disabled="createFamilyStore.family.housing.housing_type.name !== 'other' || !items.other"
                    :placeholder="$t('housing.placeholders.other')"
                    :value="
                        createFamilyStore.family.housing.housing_type.name === 'other'
                            ? createFamilyStore.family.housing.housing_type.value
                            : null
                    "
                    class="w-full md:w-3/4"
                    type="text"
                    @input="setValue"
                ></base-form-input>
            </div>
        </div>
    </div>

    <div class="intro-x mt-6 flex flex-col md:flex-row md:gap-16">
        <div class="w-full text-lg md:w-1/2">
            <p class="md:ms-11">
                {{ $t('housing.label.number_of_rooms') }}
            </p>
        </div>

        <div class="w-full">
            <base-form-input
                v-model="createFamilyStore.family.housing.number_of_rooms"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('housing.label.number_of_rooms')
                    })
                "
                class="w-full md:w-3/4"
                type="text"
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error :form class="col-span-12 lg:col-start-5" field_name="housing.number_of_rooms">
            </base-form-input-error>
        </div>
    </div>

    <div
        v-if="createFamilyStore.family.housing.housing_type.name !== 'independent'"
        class="intro-x mt-6 flex flex-col md:flex-row md:gap-16"
    >
        <div class="w-full text-lg md:w-1/2">
            <p class="md:ms-11">
                {{ $t('housing.label.housing_receipt_number') }}
            </p>
        </div>

        <div class="mt-2 w-full md:mt-0">
            <base-form-input
                v-model="createFamilyStore.family.housing.housing_receipt_number"
                :placeholder="$t('housing.placeholders.housing_receipt_number')"
                class="w-full md:w-3/4"
                type="text"
            ></base-form-input>

            <base-form-input-error :form class="col-span-12 lg:col-start-5" field_name="housing.housing_receipt_number">
            </base-form-input-error>
        </div>
    </div>
</template>

<style lang="css">
.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
