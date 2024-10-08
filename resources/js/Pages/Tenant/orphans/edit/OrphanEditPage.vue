<script lang="ts" setup>
import type { OrphanUpdateFormType } from '@/types/orphans'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, provide, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { $t } from '@/utils/i18n'

const GeneralInformation = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/edit/GeneralInformation.vue'))

const OrphanMenu = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/edit/OrphanMenu.vue'))

const SponsorshipsInformation = defineAsyncComponent(
    () => import('@/Pages/Tenant/orphans/edit/SponsorshipsInformation.vue')
)

const AcademicAchievement = defineAsyncComponent(
    () => import('@/Pages/Tenant/orphans/edit/academic-achievement/AcademicAchievement.vue')
)

const CollegeAchievement = defineAsyncComponent(
    () => import('@/Pages/Tenant/orphans/edit/college-achievement/CollegeAchievement.vue')
)

const VocationalTrainingAchievement = defineAsyncComponent(
    () => import('@/Pages/Tenant/orphans/edit/vocational-training-achievement/VocationalTrainingAchievement.vue')
)

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    orphan: OrphanUpdateFormType
}>()

const orphan = ref(props.orphan)

const view = ref('general_information')

function updateView(newValue: string) {
    view.value = newValue
}

provide('orphanDetailView', { view, updateView })
</script>

<template>
    <Head :title="$t('orphan profile')"></Head>

    <suspense>
        <div>
            <div class="intro-y mt-8 flex items-center">
                <h2 class="me-auto text-lg font-medium ltr:capitalize">
                    {{ $t('orphan profile') }}
                </h2>
            </div>

            <div class="mt-5 grid grid-cols-12 gap-6">
                <orphan-menu :orphan></orphan-menu>

                <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                    <div class="grid grid-cols-12 gap-6">
                        <general-information
                            v-if="view === 'general_information'"
                            :orphan
                            @orphan-updated="orphan = $event"
                        ></general-information>

                        <sponsorships-information
                            v-if="view === 'sponsorships_information'"
                            :orphan
                        ></sponsorships-information>

                        <academic-achievement v-if="view === 'academic_achievement'" :orphan></academic-achievement>

                        <college-achievement v-if="view === 'college_achievement'" :orphan></college-achievement>

                        <vocational-training-achievement
                            v-if="view === 'vocational_training_achievement'"
                            :orphan
                        ></vocational-training-achievement>
                    </div>
                </div>
            </div>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
