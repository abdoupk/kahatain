<script lang="ts" setup>
import type { OrphanUpdateFormType } from '@/types/orphans'

import { useVocationalTrainingAchievementsStore } from '@/stores/vocational-training-achievement'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

import DataTable from '@/Pages/Tenant/orphans/edit/vocational-training-achievement/DataTable.vue'
import VocationalTrainingAchievementCreateEditModal from '@/Pages/Tenant/orphans/edit/vocational-training-achievement/VocationalTrainingAchievementCreateEditModal.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import DeleteModal from '@/Components/Global/DeleteModal.vue'
import NoResultsFound from '@/Components/Global/NoResultsFound.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

const props = defineProps<{
    orphan: OrphanUpdateFormType
}>()

const createEditModalStatus = ref(false)

const deleteModalStatus = ref(false)

const deleteVocationalTrainingAchievement = () => {
    deleteProgress.value = true

    router.delete(
        route('tenant.vocational-training-achievements.destroy', selectedVocationalTrainingAchievementId.value),
        {
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
                        }
                    }
                )
            }
        }
    )
}

const selectedVocationalTrainingAchievementId = ref('')

const vocationalTrainingAchievementsStore = useVocationalTrainingAchievementsStore()

const deleteProgress = ref(false)

const showDeleteModal = (id: string) => {
    selectedVocationalTrainingAchievementId.value = id

    deleteModalStatus.value = true
}

const showCreateModal = () => {
    vocationalTrainingAchievementsStore.$reset()

    vocationalTrainingAchievementsStore.vocationalTrainingAchievement.orphan_id = props.orphan.id

    createEditModalStatus.value = true
}

const showEditModal = (id: string) => {
    selectedVocationalTrainingAchievementId.value = id

    vocationalTrainingAchievementsStore.getVocationalTrainingAchievement(selectedVocationalTrainingAchievementId.value)

    createEditModalStatus.value = true
}
</script>

<template>
    <!-- BEGIN: Academic Achievement -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <base-button class="ms-auto w-20 border-dashed" variant="outline-primary" @click="showCreateModal">
                <svg-loader class="h-4 w-4 dark:fill-slate-300/40" name="icon-plus"></svg-loader>
            </base-button>
        </div>

        <div class="p-5">
            <data-table
                v-if="orphan.vocational_training_achievements.length > 0"
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

    <vocational-training-achievement-create-edit-modal
        :open="createEditModalStatus"
        @close="createEditModalStatus = false"
    ></vocational-training-achievement-create-edit-modal>

    <delete-modal
        :deleteProgress
        :open="deleteModalStatus"
        @close="deleteModalStatus = false"
        @delete="deleteVocationalTrainingAchievement"
    ></delete-modal>
</template>
