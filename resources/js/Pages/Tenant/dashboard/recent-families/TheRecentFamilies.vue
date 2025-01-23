<script lang="ts" setup>
import type { RecentFamiliesType } from '@/types/dashboard'

import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

import TheDesktopView from '@/Pages/Tenant/dashboard/recent-families/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/dashboard/recent-families/TheMobileView.vue'

import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import DeleteModal from '@/Components/Global/DeleteModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { getDataForIndexPages } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

defineProps<{
    recentFamilies: RecentFamiliesType
}>()

const deleteModalStatus = ref<boolean>(false)

const deleteProgress = ref<boolean>(false)

const showSuccessNotification = ref<boolean>(false)

const showDeletionError = ref<boolean>(false)

const selectedFamilyId = ref<string>('')

const deletionReason = ref<string>('')

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedFamilyId.value = ''

    deleteProgress.value = false
}

const deleteFamily = () => {
    if (deletionReason.value.length < 20) {
        showDeletionError.value = true
    } else {
        router.put(
            route('tenant.families.destroy', selectedFamilyId.value),
            { reason: deletionReason.value },
            {
                preserveScroll: true,
                onStart: () => {
                    deleteProgress.value = true
                },
                onSuccess: () => {
                    getDataForIndexPages(
                        route('tenant.dashboard'),
                        {},
                        {
                            onStart: () => {
                                closeDeleteModal()
                            },
                            onFinish: () => {
                                showSuccessNotification.value = true

                                showDeletionError.value = false

                                deletionReason.value = ''

                                setTimeout(() => {
                                    showSuccessNotification.value = false
                                }, 2000)
                            },
                            preserveScroll: true,
                            preserveState: true,
                            only: ['recentFamilies']
                        }
                    )
                }
            }
        )
    }
}

const showDeleteModal = (familyId: string) => {
    selectedFamilyId.value = familyId

    deleteModalStatus.value = true
}
</script>

<template>
    <suspense suspensible>
        <div class="col-span-12 mt-6">
            <div class="intro-y block h-10 items-center sm:flex">
                <h2 class="me-5 truncate text-lg font-medium rtl:font-semibold">{{ $t('Recent Added Families') }}</h2>
            </div>
            <div class="@container">
                <the-desktop-view :recent-families @delete-family="showDeleteModal"></the-desktop-view>

                <the-mobile-view :recent-families @delete-family="showDeleteModal"></the-mobile-view>

                <delete-modal
                    :deleteProgress
                    :open="deleteModalStatus"
                    @close="closeDeleteModal"
                    @delete="deleteFamily"
                >
                    <div class="mt-2 text-slate-500">
                        <slot>
                            {{ $t('Do you really want to delete this record?') }} <br />
                            {{ $t('please_provide_the_reason_for_deleting_this_family') }}
                        </slot>
                    </div>

                    <div class="text-start">
                        <base-form-label for="deletion_reason">
                            {{ $t('deletion_reason') }}
                        </base-form-label>

                        <base-form-text-area
                            id="deletion_reason"
                            v-model="deletionReason"
                            rows="4"
                        ></base-form-text-area>

                        <base-input-error
                            v-if="showDeletionError"
                            :message="$t('validation.min.string', { min: 20, attribute: $t('deletion_reason') })"
                        ></base-input-error>
                    </div>
                </delete-modal>

                <success-notification
                    :open="showSuccessNotification"
                    :title="$tc('successfully_trashed', 0, { attribute: $t('the_family') })"
                ></success-notification>
            </div>
        </div>
    </suspense>

    <!--        <div class="intro-y mt-8 overflow-auto sm:mt-0 lg:overflow-visible">-->
    <!--            -->
    <!--        </div>-->
</template>
