<script lang="ts" setup>
import type { SiteSettingsType } from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { ref } from 'vue'

import BaseFilePond from '@/Components/Base/FilePond/BaseFilePond.vue'
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import TheCitySelector from '@/Components/Global/CitySelector/TheCitySelector.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheMemberSelector from '@/Components/Global/TheMemberSelector.vue'

const props = defineProps<{
    settings: SiteSettingsType
}>()

const showSuccessNotification = ref(false)

const hostname = '.' + new URL(import.meta.env.VITE_APP_URL).hostname

const blurDomainField = (event: Event) => {
    let str = (event.target as HTMLInputElement).value

    form.domain = str.endsWith('-') ? str.slice(0, -1) + '' : str
}

const updateDomainName = (event: Event) => {
    let str = (event.target as HTMLInputElement).value

    str = str.replace(/[^a-zA-Z0-9\s-]|^[0-9]+|([a-zA-Z-])[0-9]+(?=[a-zA-Z-\s])/g, '$1')

    str = str.replace(/\s+/g, '-')

    str = str.replace(/--+|^-+/g, '-')

    str = str.replace(/(-[0-9]+)+$/g, '$1')

    form.domain = str.replace(/-(?=\d+)/g, '')
}

const form = useForm<SiteSettingsType>('patch', route('tenant.site-settings.update-infos'), {
    association: props.settings.association,
    address: props.settings.address,
    domain: props.settings.domain,
    // @ts-ignore
    super_admin: props.settings.super_admin.id,
    city: props.settings.city,
    city_id: props.settings.city_id,
    logo: props.settings.logo
})

const submit = () => {
    form.submit({
        onSuccess: () => {
            showSuccessNotification.value = true

            setTimeout(() => {
                showSuccessNotification.value = false
            }, 1000)
        }
    })
}
</script>

<template>
    <div class="intro-y box col-span-12 @container lg:col-span-7 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('general_information_of_association') }}</h2>
        </div>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-4 p-5">
                <!-- BEGIN: Association Name -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="association">
                        {{ $t('validation.attributes.association') }}
                    </base-form-label>

                    <base-form-input
                        id="association"
                        v-model="form.association"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.association')
                            })
                        "
                        data-test="orphan_association"
                        type="text"
                        @change="form?.validate('association')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="association"> </base-form-input-error>
                </div>
                <!-- END: Association Name -->

                <!-- BEGIN: Super Admin -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label htmlFor="super_admin">
                        {{ $t('super_admin') }}
                    </base-form-label>

                    <div>
                        <!-- @vue-ignore -->
                        <the-member-selector
                            id="super_admin"
                            v-model:member="form.super_admin"
                            :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('super_admin') })"
                            @update:members="
                                (e) => {
                                    form.super_admin = e.id
                                    form.validate('super_admin')
                                }
                            "
                        ></the-member-selector>
                    </div>

                    <div v-if="form.errors?.super_admin" class="mt-2">
                        <base-input-error :message="form.errors.super_admin"></base-input-error>
                    </div>
                </div>
                <!-- END: Super Admin -->

                <!-- BEGIN: Domain -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="domain">
                        {{ $t('validation.attributes.domain') }}
                    </base-form-label>

                    <base-input-group class="rtl:flex-row-reverse">
                        <base-form-input
                            id="domain"
                            v-model="form.domain"
                            class="!rounded-none !rounded-s"
                            dir="ltr"
                            placeholder="el-baraka"
                            type="text"
                            @blur="blurDomainField"
                            @input="
                                (e) => {
                                    updateDomainName(e)
                                    form?.validate('domain')
                                }
                            "
                        ></base-form-input>

                        <base-input-group-text class="rtl:!rounded-none rtl:!rounded-s">
                            <p dir="ltr">{{ hostname }}</p>
                        </base-input-group-text>
                    </base-input-group>

                    <base-form-input-error :form field_name="domain"> </base-form-input-error>
                </div>
                <!-- END: Domain -->

                <!-- BEGIN: Address -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="address">
                        {{ $t('validation.attributes.address') }}
                    </base-form-label>

                    <base-form-input
                        id="address"
                        v-model="form.address"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.address')
                            })
                        "
                        data-test="orphan_address"
                        type="text"
                        @change="form?.validate('address')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="address"> </base-form-input-error>
                </div>
                <!-- END: Address -->

                <!-- BEGIN: City -->
                <div class="col-span-12">
                    <the-city-selector
                        v-model:city="form.city"
                        v-model:city-id="form.city_id"
                        :error-message="form.errors.city_id"
                        @update:city-id="
                            () => {
                                form.validate('city_id')
                            }
                        "
                    ></the-city-selector>
                </div>
                <!-- END: City -->

                <div class="col-span-12">
                    <base-form-label for="logo">
                        {{ $t('validation.attributes.logo') }}
                    </base-form-label>

                    <base-file-pond
                        id="logo"
                        :allow-multiple="false"
                        :files="settings.logo"
                        @update:files="form.logo = $event[0]"
                    ></base-file-pond>
                </div>

                <base-button :disabled="form.processing" class="!mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>

    <success-notification
        :open="showSuccessNotification"
        :title="
            $t('successfully_updated', {
                attribute: $t('tenant_settings')
            })
        "
    ></success-notification>
</template>
