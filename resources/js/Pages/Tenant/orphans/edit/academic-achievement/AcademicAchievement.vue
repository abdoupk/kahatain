<script lang="ts" setup>
import type { OrphanUpdateFormType } from '@/types/orphans'

import { useAcademicAchievementsStore } from '@/stores/academic-achievement'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

import AcademicAchievementCreateEditModal from '@/Pages/Tenant/orphans/edit/academic-achievement/AcademicAchievementCreateEditModal.vue'
import DataTable from '@/Pages/Tenant/orphans/edit/academic-achievement/DataTable.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import DeleteModal from '@/Components/Global/DeleteModal.vue'
import NoResultsFound from '@/Components/Global/NoResultsFound.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

import { $tc } from '@/utils/i18n'

const props = defineProps<{
    orphan: OrphanUpdateFormType
}>()

const createEditModalStatus = ref(false)

const deleteModalStatus = ref(false)

const deleteAcademicAchievement = () => {
    deleteProgress.value = true

    router.delete(route('tenant.academic-achievements.destroy', selectedAcademicAchievementId.value), {
        // TODO get only academic achievements and not reload entire page
        onSuccess: () => {
            router.get(
                route('tenant.orphans.edit', props.orphan.id),
                {},
                {
                    only: ['orphan'],
                    preserveScroll: true,
                    preserveState: false,
                    onSuccess: () => {
                        deleteProgress.value = false

                        deleteModalStatus.value = false
                    },
                    onFinish: () => {
                        showSuccessNotification.value = true

                        setTimeout(() => {
                            showSuccessNotification.value = false
                        }, 2000)
                    }
                }
            )
        }
    })
}

const selectedAcademicAchievementId = ref('')

const academicAchievementsStore = useAcademicAchievementsStore()

const deleteProgress = ref(false)

const showSuccessNotification = ref(false)

const showDeleteModal = (id: string) => {
    selectedAcademicAchievementId.value = id

    deleteModalStatus.value = true
}

const showCreateModal = () => {
    academicAchievementsStore.$reset()

    academicAchievementsStore.academicAchievement.orphan_id = props.orphan.id

    createEditModalStatus.value = true
}

const showEditModal = (id: string) => {
    selectedAcademicAchievementId.value = id

    academicAchievementsStore.getAcademicAchievement(selectedAcademicAchievementId.value)

    createEditModalStatus.value = true
}
</script>

<template>
    <!-- BEGIN: Academic Achievement -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="text-base font-bold">{{ orphan?.last_academic_year_achievement }}</h2>

            <base-button class="ms-auto w-20 border-dashed" variant="outline-primary" @click="showCreateModal">
                <svg-loader class="h-4 w-4 dark:fill-slate-300/40" name="icon-plus"></svg-loader>
            </base-button>
        </div>

        <div class="p-5">
            <data-table
                v-if="orphan.academic_achievements.length > 0"
                :orphan
                @show-delete-modal="showDeleteModal"
                @show-edit-modal="showEditModal"
            ></data-table>

            <div v-else class="intro-x mt-12 flex flex-col items-center justify-center">
                <no-results-found></no-results-found>
            </div>
        </div>
    </div>
    <!-- END: Academic Achievement -->

    <academic-achievement-create-edit-modal
        :open="createEditModalStatus"
        @close="createEditModalStatus = false"
    ></academic-achievement-create-edit-modal>

    <delete-modal
        :deleteProgress
        :open="deleteModalStatus"
        @close="deleteModalStatus = false"
        @delete="deleteAcademicAchievement"
    ></delete-modal>

    <success-notification
        :open="showSuccessNotification"
        :title="$tc('successfully_trashed', 0, { attribute: $t('academic_achievement') })"
    ></success-notification>
</template>
