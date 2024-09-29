<script lang="ts" setup>
import type { EventType, SchoolType } from '@/types/lessons'

import { useLessonsStore } from '@/stores/lessons'
import { type EventApi } from '@fullcalendar/core'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

const LessonCreateModal = defineAsyncComponent(() => import('@/Pages/Tenant/lessons/create/LessonCreateModal.vue'))

const LessonActionsModal = defineAsyncComponent(() => import('@/Pages/Tenant/lessons/index/LessonActionsModal.vue'))

const BaseCalendar = defineAsyncComponent(() => import('@/Components/Base/calendar/BaseCalendar.vue'))

defineOptions({
    layout: TheLayout
})

defineProps<{ schools: SchoolType[]; events: EventType[] }>()

const createModalStatus = ref(false)

const deleteProgress = ref(false)

const showSuccessNotificationStatus = ref(false)

const date = ref('')

const actionsModalStatus = ref(false)

const lessonsStore = useLessonsStore()

const openCreateModal = (args: { dateStr: string }) => {
    date.value = args.dateStr

    lessonsStore.$reset()

    createModalStatus.value = true
}

const handleEventChange = (event: EventApi) => {
    const { id, startStr, endStr } = event

    lessonsStore
        .updateLesson(id, {
            start_date: startStr,
            end_date: endStr
        })
        .then(() => {
            showSuccessNotificationStatus.value = true

            setTimeout(() => {
                showSuccessNotificationStatus.value = false
            }, 1000)
        })
}

const selectedEvent = ref<EventApi | null>(null)

const HandleEventClick = async (event: EventApi) => {
    await lessonsStore.getLesson(event.id)

    actionsModalStatus.value = true

    selectedEvent.value = event
}

const deleteLesson = () => {
    deleteProgress.value = true

    router.delete(route('tenant.lessons.destroy', selectedEvent.value?.id), {
        onSuccess: () => {
            router.get(
                route('tenant.lessons.index'),
                {},
                {
                    only: ['events'],
                    preserveState: false,
                    onSuccess: () => {
                        deleteProgress.value = false

                        actionsModalStatus.value = false

                        selectedEvent.value = null
                    }
                }
            )
        }
    })
}

const handleEditLesson = () => {
    actionsModalStatus.value = false

    setTimeout(() => {
        createModalStatus.value = true
    }, 200)
}
</script>

<template>
    <Head :title="$t('the_lessons')"></Head>

    <suspense>
        <div>
            <h2 class="intro-y mt-10 text-lg font-medium">
                {{ $t('list', { attribute: $t('the_lessons') }) }}
            </h2>

            <div class="mt-5 grid grid-cols-12 gap-6">
                <div class="intro-y box col-span-12 mt-2 flex flex-wrap items-center p-5">
                    <base-calendar
                        :events
                        class="w-full"
                        @event-click="HandleEventClick"
                        @date-click="openCreateModal"
                        @event-drop="handleEventChange"
                        @event-resize="handleEventChange"
                    ></base-calendar>
                </div>
            </div>

            <lesson-create-modal
                :date
                :open="createModalStatus"
                :schools
                @close="createModalStatus = false"
            ></lesson-create-modal>

            <lesson-actions-modal
                :deleteProgress
                :eventInfo="selectedEvent"
                :open="actionsModalStatus"
                @close="actionsModalStatus = false"
                @delete="deleteLesson"
                @edit="handleEditLesson"
            ></lesson-actions-modal>

            <success-notification
                :open="showSuccessNotificationStatus"
                :title="
                    $t('successfully_updated', {
                        attribute: $t('the_lesson')
                    })
                "
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
