<script lang="ts" setup>
import type { CreateFamilyForm } from '@/types/types'

import { useCreateFamilyStore } from '@/stores/create-family'
import type { Form } from 'laravel-precognition-vue/dist/types'
import { nextTick, onMounted } from 'vue'

import BaseFilePond from '@/Components/Base/FilePond/BaseFilePond.vue'
import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const props = defineProps<{ form: Form<CreateFamilyForm> }>()

const createFamilyStore = useCreateFamilyStore()

const _deathCertificateFiles = props.form?.deceased.map((deceased) => deceased.death_certificate_file)

onMounted(() => {
    document.getElementById('first_name_0')?.focus()
})

const addDeceased = () => {
    createFamilyStore.family.deceased.push({
        first_name: '',
        last_name: '',
        birth_date: null,
        death_certificate_file: null,
        income: '',
        function: '',
        death_date: null
    })

    nextTick(() => {
        document.getElementById(`first_name_${createFamilyStore.family.deceased.length - 1}`)?.focus()
    })
}

const removeDeceased = (index: number) => {
    if (index > 0) {
        createFamilyStore.family.deceased.splice(index, 1)
    }
}
</script>

<template>
    <div v-for="(deceased, index) in createFamilyStore.family.deceased" :key="index">
        <div class="mb-4 mt-6 flex">
            <p class="text-base font-medium">
                {{ $t('deceased no', { no: String(index + 1) }) }}
            </p>

            <button class="me-2 ms-auto"></button>

            <a
                :class="{ hidden: createFamilyStore.family.deceased.length === 0 }"
                class="ms-2 inline-block !outline-none focus-visible:!rounded-sm focus-visible:!outline-red-300/70"
                href="#"
                @click.prevent="removeDeceased(index)"
            >
                <svg-loader class="fill-danger" name="icon-trash-can"></svg-loader>
            </a>
        </div>

        <div class="grid grid-cols-12 gap-4 gap-y-5">
            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`first_name_${index}`">
                    {{ $t('validation.attributes.first_name') }}
                </base-form-label>

                <base-form-input
                    :id="`first_name_${index}`"
                    v-model="createFamilyStore.family.deceased[index].first_name"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('validation.attributes.first_name')
                        })
                    "
                    autofocus
                    type="text"
                    @change="form?.validate(`deceased.${index}.first_name`)"
                ></base-form-input>

                <base-form-input-error :field_name="`deceased.${index}.first_name`" :form></base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`last_name_${index}`">
                    {{ $t('validation.attributes.last_name') }}
                </base-form-label>

                <base-form-input
                    :id="`last_name_${index}`"
                    v-model="createFamilyStore.family.deceased[index].last_name"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('validation.attributes.last_name')
                        })
                    "
                    type="text"
                    @change="form?.validate(`deceased.${index}.last_name`)"
                ></base-form-input>

                <base-form-input-error :field_name="`deceased.${index}.last_name`" :form></base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`birth_date_${index}`">
                    {{ $t('validation.attributes.sponsor.birth_date') }}
                </base-form-label>

                <base-v-calendar
                    :id="`birth_date_${index}`"
                    v-model:date="createFamilyStore.family.deceased[index].birth_date"
                ></base-v-calendar>

                <base-form-input-error :field_name="`deceased.${index}.birth_date`" :form></base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`death_date_${index}`">
                    {{ $t('validation.attributes.spouse.death_date') }}
                </base-form-label>

                <base-v-calendar
                    :id="`death_date_${index}`"
                    v-model:date="createFamilyStore.family.deceased[index].death_date"
                    :placeholder="
                        $t('auth.placeholders.fill', { attribute: $t('validation.attributes.spouse.death_date') })
                    "
                ></base-v-calendar>

                <base-form-input-error :field_name="`deceased.${index}.death_date`" :form></base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`type_${index}`">
                    {{ $t('deceased_type') }}
                </base-form-label>

                <base-form-select
                    :id="`type_${index}`"
                    v-model="createFamilyStore.family.deceased[index].type"
                    type="text"
                    @change="form?.validate(`deceased.${index}.type`)"
                >
                    <option value="">{{ $t('filters.select_an_option') }}</option>
                    <option value="father">{{ $t('father') }}</option>
                    <option value="mother">{{ $t('mother') }}</option>
                </base-form-select>

                <base-form-input-error :field_name="`deceased.${index}.type`" :form></base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`function_${index}`">
                    {{ $t('validation.attributes.spouse.function') }}
                </base-form-label>

                <base-form-input
                    :id="`function_${index}`"
                    v-model="createFamilyStore.family.deceased[index].function"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('validation.attributes.sponsor.function')
                        })
                    "
                    type="text"
                    @change="form?.validate(`deceased.${index}.function`)"
                ></base-form-input>

                <base-form-input-error :field_name="`deceased.${index}.function`" :form></base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`income_${index}`">
                    {{ $t('validation.attributes.spouse.income') }}
                </base-form-label>

                <base-form-input
                    :id="`income_${index}`"
                    v-model="createFamilyStore.family.deceased[index].income"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('validation.attributes.income')
                        })
                    "
                    type="text"
                    @change="form?.validate(`deceased.${index}.income`)"
                    @keydown="allowOnlyNumbersOnKeyDown"
                ></base-form-input>

                <base-form-input-error :field_name="`deceased.${index}.income`" :form></base-form-input-error>
            </div>

            <div class="col-span-12 lg:col-span-6 lg:col-start-1">
                <base-form-label :for="`death_certificate_file_${index}`" class="mb-2">
                    {{ $t('upload-files.labels.death_certificate') }}
                </base-form-label>

                <base-file-pond
                    :id="`death_certificate_file_${index}`"
                    :allow-multiple="false"
                    :files="_deathCertificateFiles[index]"
                    :is-picture="false"
                    :labelIdle="$t('upload-files.labelIdle.spouse_death_certificate')"
                    accepted-file-types="image/jpeg, image/png, application/pdf"
                    @update:files="createFamilyStore.family.deceased[index].death_certificate_file = $event[0]"
                ></base-file-pond>
            </div>
        </div>
    </div>

    <base-button
        v-if="createFamilyStore.family.deceased.length < 2"
        class="mx-auto mt-4 block w-1/2 border-dashed dark:text-slate-500"
        type="button"
        variant="outline-primary"
        @click="addDeceased"
    >
        <svg-loader class="inline fill-primary dark:fill-slate-500" name="icon-plus"></svg-loader>

        {{ $tc('add new', 1, { attribute: $t('deceased') }) }}
    </base-button>
</template>
