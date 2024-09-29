<script lang="ts" setup>
import type { OrphanUpdateFormType } from '@/types/orphans'

import { useCollegeAchievementsStore } from '@/stores/college-achievement'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

import CollegeAchievementCreateEditModal from '@/Pages/Tenant/orphans/edit/college-achievement/CollegeAchievementCreateEditModal.vue'
import DataTable from '@/Pages/Tenant/orphans/edit/college-achievement/DataTable.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import DeleteModal from '@/Components/Global/DeleteModal.vue'
import NoResultsFound from '@/Components/Global/NoResultsFound.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

const props = defineProps<{
    orphan: OrphanUpdateFormType
}>()

const createEditModalStatus = ref(false)

const deleteModalStatus = ref(false)

const deleteCollegeAchievement = () => {
    deleteProgress.value = true

    router.delete(route('tenant.college-achievements.destroy', selectedCollegeAchievementId.value), {
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
    })
}

const selectedCollegeAchievementId = ref('')

const collegeAchievementsStore = useCollegeAchievementsStore()

const deleteProgress = ref(false)

const showDeleteModal = (id: string) => {
    selectedCollegeAchievementId.value = id

    deleteModalStatus.value = true
}

const showCreateModal = () => {
    collegeAchievementsStore.$reset()

    collegeAchievementsStore.collegeAchievement.orphan_id = props.orphan.id

    createEditModalStatus.value = true
}

const showEditModal = (id: string) => {
    selectedCollegeAchievementId.value = id

    collegeAchievementsStore.getCollegeAchievement(selectedCollegeAchievementId.value)

    createEditModalStatus.value = true
}
</script>

<template>
    <!-- BEGIN: College Achievement -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <base-button class="ms-auto w-20 border-dashed" variant="outline-primary" @click="showCreateModal">
                <svg-loader class="h-4 w-4 dark:fill-slate-300/40" name="icon-plus"></svg-loader>
            </base-button>
        </div>

        <div class="p-5">
            <data-table
                v-if="orphan.college_achievements.length > 0"
                :orphan
                @show-delete-modal="showDeleteModal"
                @show-edit-modal="showEditModal"
            ></data-table>

            <div v-else class="intro-x mt-12 flex flex-col items-center justify-center">
                <no-results-found></no-results-found>
            </div>
        </div>
    </div>
    <!-- END: College Achievement -->

    <college-achievement-create-edit-modal
        :open="createEditModalStatus"
        @close="createEditModalStatus = false"
    ></college-achievement-create-edit-modal>

    <delete-modal
        :deleteProgress
        :open="deleteModalStatus"
        @close="deleteModalStatus = false"
        @delete="deleteCollegeAchievement"
    ></delete-modal>
</template>
