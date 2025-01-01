<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import { useMembersStore } from '@/stores/members'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, defineAsyncComponent, onMounted, ref } from 'vue'

import BaseSlideoverDescription from '@/Components/Base/headless/Slideover/BaseSlideoverDescription.vue'
import CreateEditSlideOver from '@/Components/Global/CreateEditSlideOver.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheAcademicLevelSelector from '@/Components/Global/TheAcademicLevelSelector.vue'
import TheAddressField from '@/Components/Global/TheAddressField/TheAddressField.vue'
import TheCommitteeSelector from '@/Components/Global/TheCommitteeSelector.vue'
import TheCompetenceSelector from '@/Components/Global/TheCompetenceSelector.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseFormSelect = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormSelect.vue'))

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const TheBranchSelector = defineAsyncComponent(() => import('@/Components/Global/TheBranchSelector.vue'))

const TheRoleSelector = defineAsyncComponent(() => import('@/Components/Global/TheRoleSelector.vue'))

const TheZoneSelector = defineAsyncComponent(() => import('@/Components/Global/TheZoneSelector.vue'))

defineProps<{
    open: boolean
}>()

// Get the members store
const membersStore = useMembersStore()

// Initialize a ref for loading state
const loading = ref(false)

const form = computed(() => {
    if (membersStore.member.id) {
        return useForm('put', route('tenant.members.update', membersStore.member.id), { ...membersStore.member })
    }

    return useForm('post', route('tenant.members.store'), { ...membersStore.member })
})

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const academicLevels = ref<AcademicLevelType[]>([])

const academicLevelsStore = useAcademicLevelsStore()

onMounted(async () => {
    academicLevels.value = await academicLevelsStore.getAcademicLevelsForOrphans()
})

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    setTimeout(() => {
        router.get(
            route('tenant.members.index'),
            {},
            {
                only: ['members'],
                preserveState: true
            }
        )
    }, 200)

    emit('close')
}

// Function to handle form submission
const handleSubmit = async () => {
    loading.value = true

    try {
        await form.value
            .submit({
                onSuccess() {
                    showSuccessNotification.value = true
                },
                onFinish() {
                    showSuccessNotification.value = false
                }
            })
            .then(handleSuccess)
    } finally {
        loading.value = false
    }
}

// Compute the slideover title based on the member id
const modalTitle = computed(() => {
    return membersStore.member.id
        ? $t('modal_update_title', { attribute: $t('the_member') })
        : $tc('add new', 1, { attribute: $t('member') })
})

const showSuccessNotification = ref(false)

const notificationTitle = computed(() => {
    return membersStore.member.id
        ? $t('successfully_updated')
        : $t('successfully_created', { attribute: $t('the_member') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the member id
const modalType = computed(() => {
    return membersStore.member.id ? 'update' : 'create'
})
</script>

<template>
    <create-edit-slide-over
        :focusable-input="firstInputRef"
        :loading
        :modal-type="modalType"
        :open
        :slideover-type="modalType"
        :title="modalTitle"
        size="xl"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #description>
            <base-slideover-description class="grid grid-cols-12 gap-4 gap-y-3 overflow-hidden p-0 px-1 pb-5">
                <!-- Begin: First name-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="first_name">
                        {{ $t('validation.attributes.first_name') }}
                    </base-form-label>

                    <base-form-input
                        id="first_name"
                        ref="firstInputRef"
                        v-model="form.first_name"
                        :placeholder="
                            $t('auth.placeholders.fill', { attribute: $t('validation.attributes.first_name') })
                        "
                        type="text"
                        @change="form.validate('first_name')"
                    />

                    <div v-if="form.errors?.first_name" class="mt-2">
                        <base-input-error :message="form.errors.first_name"></base-input-error>
                    </div>
                </div>
                <!-- End: First name-->

                <!-- Begin: Last name-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="last_name">
                        {{ $t('validation.attributes.last_name') }}
                    </base-form-label>

                    <base-form-input
                        id="last_name"
                        v-model="form.last_name"
                        :placeholder="
                            $t('auth.placeholders.fill', { attribute: $t('validation.attributes.last_name') })
                        "
                        type="text"
                        @change="form.validate('last_name')"
                    />

                    <div v-if="form.errors?.last_name" class="mt-2">
                        <base-input-error :message="form.errors.last_name"></base-input-error>
                    </div>
                </div>
                <!-- End: Last name-->

                <!-- Begin: Email-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="email">
                        {{ $t('validation.attributes.email') }}
                    </base-form-label>

                    <base-form-input
                        id="email"
                        v-model="form.email"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.email') })"
                        class="[&[readonly]]:cursor-default [&[readonly]]:bg-white [&[readonly]]:dark:bg-darkmode-800"
                        onfocus="this.removeAttribute('readonly')"
                        readonly
                        type="email"
                        @change="form.validate('email')"
                    />

                    <div v-if="form.errors?.email" class="mt-2">
                        <base-input-error :message="form.errors.email"></base-input-error>
                    </div>
                </div>
                <!-- End: Email-->

                <!-- Begin: Phone-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="phone">
                        {{ $t('validation.attributes.phone') }}
                    </base-form-label>

                    <base-form-input
                        id="phone"
                        v-model="form.phone"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.phone') })"
                        class="[&[readonly]]:cursor-default [&[readonly]]:bg-white [&[readonly]]:dark:bg-darkmode-800"
                        maxlength="10"
                        onfocus="this.removeAttribute('readonly')"
                        readonly
                        type="text"
                        @change="form.validate('phone')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    />

                    <div v-if="form.errors?.phone" class="mt-2">
                        <base-input-error :message="form.errors.phone"></base-input-error>
                    </div>
                </div>
                <!-- End: Phone-->

                <template v-if="!membersStore.member.id">
                    <!-- Begin: Password-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label htmlFor="password">
                            {{ $t('validation.attributes.password') }}
                        </base-form-label>

                        <base-form-input
                            id="password"
                            v-model="form.password"
                            :placeholder="
                                $t('auth.placeholders.fill', { attribute: $t('validation.attributes.password') })
                            "
                            class="[&[readonly]]:cursor-default [&[readonly]]:bg-white [&[readonly]]:dark:bg-darkmode-800"
                            onfocus="this.removeAttribute('readonly')"
                            readonly
                            type="password"
                            @change="form.validate('password')"
                        />

                        <div v-if="form.errors?.password" class="mt-2">
                            <base-input-error :message="form.errors.password"></base-input-error>
                        </div>
                    </div>
                    <!-- End: Password-->

                    <!-- Begin: Password Confirmation-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label htmlFor="password_confirmation">
                            {{ $t('validation.attributes.password_confirmation') }}
                        </base-form-label>

                        <base-form-input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            :placeholder="
                                $t('auth.placeholders.fill', {
                                    attribute: $t('validation.attributes.password_confirmation')
                                })
                            "
                            class="[&[readonly]]:cursor-default [&[readonly]]:bg-white [&[readonly]]:dark:bg-darkmode-800"
                            onfocus="this.removeAttribute('readonly')"
                            readonly
                            type="password"
                            @change="form.validate('password_confirmation')"
                        />

                        <div v-if="form.errors?.password_confirmation" class="mt-2">
                            <base-input-error :message="form.errors.password_confirmation"></base-input-error>
                        </div>
                    </div>
                    <!-- End: Password Confirmation-->
                </template>

                <!-- Begin: gender-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="gender">
                        {{ $t('validation.attributes.gender') }}
                    </base-form-label>

                    <base-form-select
                        id="gender"
                        v-model="form.gender"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.gender') })"
                        @change="form.validate('gender')"
                    >
                        <option value="male">{{ $t('male') }}</option>
                        <option value="female">{{ $t('female') }}</option>
                    </base-form-select>

                    <div v-if="form.errors?.gender" class="mt-2">
                        <base-input-error :message="form.errors.gender"></base-input-error>
                    </div>
                </div>
                <!-- End: gender-->

                <!-- Begin: qualification-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="competences">
                        {{ $t('validation.attributes.qualification') }}
                    </base-form-label>

                    <div>
                        <the-competence-selector v-model:competences="form.competences"></the-competence-selector>
                    </div>

                    <div v-if="form.errors?.qualification" class="mt-2">
                        <base-input-error :message="form.errors.qualification"></base-input-error>
                    </div>
                </div>
                <!-- End: qualification-->

                <!-- Begin: Academic Level-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="zone">
                        {{ $t('validation.attributes.academic_level_id') }}
                    </base-form-label>

                    <div>
                        <the-academic-level-selector
                            id="zone"
                            v-model:academic-level="form.academic_level_id"
                            :academic-levels
                        >
                        </the-academic-level-selector>
                    </div>

                    <div v-if="form.errors?.academic_level_id" class="mt-2">
                        <base-input-error :message="form.errors.academic_level_id"></base-input-error>
                    </div>
                </div>
                <!-- End: Academic Level-->

                <!-- Begin: zone-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="zone">
                        {{ $t('validation.attributes.zone') }}
                    </base-form-label>

                    <div>
                        <the-zone-selector
                            id="zone"
                            v-model:zone="form.zone_id"
                            @update:zone="form.validate('zone_id')"
                        ></the-zone-selector>
                    </div>

                    <div v-if="form.errors?.zone_id" class="mt-2">
                        <base-input-error :message="form.errors.zone_id"></base-input-error>
                    </div>
                </div>
                <!-- End: zone-->

                <!-- Begin: branch-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="branch">
                        {{ $t('the_branch') }}
                    </base-form-label>

                    <div>
                        <the-branch-selector
                            id="branch"
                            v-model:branch="form.branch_id"
                            @update:branch="form.validate('branch_id')"
                        ></the-branch-selector>
                    </div>

                    <div v-if="form.errors?.branch_id" class="mt-2">
                        <base-input-error :message="form.errors.branch_id"></base-input-error>
                    </div>
                </div>
                <!-- End: branch-->

                <!-- Begin: roles-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="roles">
                        {{ $t('roles') }}
                    </base-form-label>

                    <div>
                        <the-role-selector
                            id="roles"
                            v-model:formatted-roles="form.formatted_roles"
                            v-model:roles="form.roles"
                            @update:roles="form.validate('roles')"
                        ></the-role-selector>
                    </div>

                    <div v-if="form.errors?.roles" class="mt-2">
                        <base-input-error :message="form.errors.roles"></base-input-error>
                    </div>
                </div>
                <!-- End: roles-->

                <!-- Begin: address-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="address">
                        {{ $t('validation.attributes.address') }}
                    </base-form-label>

                    <the-address-field
                        id="address"
                        v-model:address="form.address"
                        v-model:location="form.location"
                        :select_location_label="$t('hints.select_member_location')"
                        @update:address="form.validate('address')"
                    ></the-address-field>

                    <div v-if="form.errors?.address" class="mt-2">
                        <base-input-error :message="form.errors.address"></base-input-error>
                    </div>
                </div>
                <!-- End: address-->

                <!-- Begin: function-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="function">
                        {{ $t('filters.function') }}
                    </base-form-label>

                    <base-form-input
                        id="function"
                        v-model="form.function"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('filters.function') })"
                        type="text"
                        @change="form.validate('function')"
                    />

                    <div v-if="form.errors?.function" class="mt-2">
                        <base-input-error :message="form.errors.function"></base-input-error>
                    </div>
                </div>
                <!-- End: function-->

                <!-- Begin: Work place-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="workplace">
                        {{ $t('validation.attributes.workplace') }}
                    </base-form-label>

                    <base-form-input
                        id="workplace"
                        v-model="form.workplace"
                        :placeholder="
                            $t('auth.placeholders.fill', { attribute: $t('validation.attributes.workplace') })
                        "
                        type="text"
                        @change="form.validate('workplace')"
                    />

                    <div v-if="form.errors?.workplace" class="mt-2">
                        <base-input-error :message="form.errors.workplace"></base-input-error>
                    </div>
                </div>
                <!-- End: Work place-->

                <!-- Begin: Committee-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="committees">
                        {{ $t('the_committees') }}
                    </base-form-label>

                    <div>
                        <the-committee-selector v-model:committees="form.committees"></the-committee-selector>
                    </div>

                    <div v-if="form.errors?.committees" class="mt-2">
                        <base-input-error :message="form.errors.committees"></base-input-error>
                    </div>
                </div>
                <!-- End: Committee-->
            </base-slideover-description>
        </template>
    </create-edit-slide-over>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
