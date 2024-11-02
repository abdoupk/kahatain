<script lang="ts" setup>
import { CreateSponsorshipForm } from '@/types/types'

import type { Form } from 'laravel-precognition-vue/dist/types'
import { defineAsyncComponent } from 'vue'

import { $t } from '@/utils/i18n'

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const BaseInputGroup = defineAsyncComponent(() => import('@/Components/Base/form/InputGroup/BaseInputGroup.vue'))

const BaseInputGroupText = defineAsyncComponent(
    () => import('@/Components/Base/form/InputGroup/BaseInputGroupText.vue')
)

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

defineProps<{
    form: Form<CreateSponsorshipForm>
    index: number
}>()

const emit = defineEmits(['removeInterval'])

const minimum = defineModel('minimum')

const maximum = defineModel('maximum')

const category = defineModel('category')
</script>

<template>
    <div class="col-span-12 grid grid-cols-12 gap-4">
        <!-- Begin: Minimum-->
        <div class="col-span-12 sm:col-span-4">
            <base-form-label htmlFor="minimum">
                {{ $t('validation.attributes.minimum') }}
            </base-form-label>

            <base-input-group>
                <base-form-input
                    id="minimum"
                    v-model="minimum"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.minimum') })"
                    type="number"
                    @change="form.validate(`categories.${index}.minimum`)"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>

            <!-- @vue-ignore -->
            <div v-if="form.invalid(`categories.${index}.minimum`)" class="mt-2">
                <!-- @vue-ignore -->
                <base-input-error :message="form.errors[`categories.${index}.minimum`]"></base-input-error>
            </div>
        </div>
        <!-- End: Minimum-->

        <!-- Begin: Maximum-->
        <div class="col-span-12 sm:col-span-4">
            <base-form-label htmlFor="maximum">
                {{ $t('validation.attributes.maximum') }}
            </base-form-label>

            <base-input-group>
                <base-form-input
                    id="maximum"
                    v-model="maximum"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.maximum') })"
                    type="number"
                    @change="form.validate(`categories.${index}.maximum`)"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>

            <!-- @vue-ignore -->
            <div v-if="form.invalid(`categories.${index}.maximum`)" class="mt-2">
                <!-- @vue-ignore -->
                <base-input-error :message="form.errors[`categories.${index}.maximum`]"></base-input-error>
            </div>
        </div>
        <!-- End: Maximum-->

        <!-- Begin: Category name-->
        <div class="col-span-12 sm:col-span-4">
            <base-form-label htmlFor="category">
                {{ $t('the_category') }}
            </base-form-label>

            <div class="flex">
                <base-form-input
                    id="category"
                    v-model="category"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('the_category') })"
                    type="text"
                    @change="form.validate(`categories.${index}.category`)"
                ></base-form-input>

                <svg-loader
                    :class="{ '!cursor-not-allowed': index === 0 }"
                    class="me-1 ms-2 mt-2 h-5 w-5 cursor-pointer fill-danger"
                    name="icon-trash-can"
                    @click.prevent="emit('removeInterval', index)"
                ></svg-loader>
            </div>

            <!-- @vue-ignore -->
            <div v-if="form.invalid(`categories.${index}.category`)" class="mt-2">
                <!-- @vue-ignore -->
                <base-input-error :message="form.errors[`categories.${index}.category`]"></base-input-error>
            </div>
        </div>
        <!-- End: Category name-->
    </div>
</template>
