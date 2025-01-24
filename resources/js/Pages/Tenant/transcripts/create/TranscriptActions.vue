<script lang="ts" setup>
import { OrphansTranscriptsIndexResource } from '@/types/types'

import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseMenu from '@/Components/Base/headless/Menu/BaseMenu.vue'
import BaseMenuButton from '@/Components/Base/headless/Menu/BaseMenuButton.vue'
import BaseMenuItem from '@/Components/Base/headless/Menu/BaseMenuItem.vue'
import BaseMenuItems from '@/Components/Base/headless/Menu/BaseMenuItems.vue'
import BasePopover from '@/Components/Base/headless/Popover/BasePopover.vue'
import BasePopoverButton from '@/Components/Base/headless/Popover/BasePopoverButton.vue'
import BasePopoverPanel from '@/Components/Base/headless/Popover/BasePopoverPanel.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    orphan: OrphansTranscriptsIndexResource
    shouldCreateFirstTrimesterTranscript: boolean
    shouldCreateSecondTrimesterTranscript: boolean
    shouldCreateThirdTrimesterTranscript: boolean
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['showCreateModal', 'showEditModal', 'showDeleteModal', 'showSuccessNotification'])

const generalAverage = ref(null)

const handleSubmitGeneralAverage = (orphanId: string, close) => {
    router.patch(
        route('tenant.transcripts.update', orphanId),
        {
            general_average: generalAverage.value
        },
        {
            onSuccess: () => {
                generalAverage.value = null

                emit('showSuccessNotification')

                close()
            }
        }
    )
}

const handleCreateTranscript = (trimester: string, orphan: OrphansTranscriptsIndexResource, close) => {
    emit('showCreateModal', {
        orphan,
        trimester
    })

    close()
}

const handleEditTranscript = (transcriptId: string, close) => {
    emit('showEditModal', transcriptId)

    close()
}

const handleDeleteTranscript = (transcriptId: string, close) => {
    emit('showDeleteModal', transcriptId)

    close()
}
</script>

<template>
    <!-- Begin: Create Transcript-->
    <base-menu v-slot="{ close }">
        <base-menu-button :as="BaseButton" class="w-full border-0 shadow-none focus:outline-none focus:ring-0">
            <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-plus"></svg-loader>

            {{ $t('create') }}
        </base-menu-button>

        <base-menu-items>
            <base-menu-item
                :disabled="!shouldCreateFirstTrimesterTranscript || orphan.transcripts.first_trimester"
                class="w-full whitespace-nowrap"
                @click.prevent="handleCreateTranscript('first_trimester', orphan, close)"
            >
                {{ $t('first_trimester') }}
            </base-menu-item>

            <base-menu-item
                :disabled="!shouldCreateSecondTrimesterTranscript || orphan.transcripts.second_trimester"
                class="w-full whitespace-nowrap"
                @click.prevent="handleCreateTranscript('second_trimester', orphan, close)"
            >
                {{ $t('second_trimester') }}
            </base-menu-item>

            <base-menu-item
                :disabled="!shouldCreateThirdTrimesterTranscript || orphan.transcripts.third_trimester"
                class="w-full whitespace-nowrap"
                @click.prevent="handleCreateTranscript('third_trimester', orphan, close)"
            >
                {{ $t('third_trimester') }}
            </base-menu-item>
        </base-menu-items>
    </base-menu>
    <!-- End: Create Transcript-->

    <!-- Begin: Update Transcript-->
    <base-menu v-slot="{ close }">
        <base-menu-button :as="BaseButton" class="-ms-1 w-full border-0 shadow-none focus:outline-none focus:ring-0">
            <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
            {{ $t('edit') }}
        </base-menu-button>

        <base-menu-items>
            <base-menu-item
                :disabled="!orphan.transcripts.first_trimester"
                class="w-full whitespace-nowrap"
                @click.prevent="handleEditTranscript(orphan.transcripts.first_trimester?.id, close)"
            >
                {{ $t('first_trimester') }}
            </base-menu-item>

            <base-menu-item
                :disabled="!orphan.transcripts.second_trimester"
                class="w-full whitespace-nowrap"
                @click.prevent="handleEditTranscript(orphan.transcripts.second_trimester?.id, close)"
            >
                {{ $t('second_trimester') }}
            </base-menu-item>

            <base-menu-item
                :disabled="!orphan.transcripts.third_trimester"
                class="w-full whitespace-nowrap"
                @click.prevent="handleEditTranscript(orphan.transcripts.third_trimester?.id, close)"
            >
                {{ $t('third_trimester') }}
            </base-menu-item>
        </base-menu-items>
    </base-menu>
    <!-- End: Update Transcript-->

    <!-- Begin: Delete Transcript-->
    <base-menu v-slot="{ close }">
        <base-menu-button :as="BaseButton" class="-ms-1 w-full border-0 shadow-none focus:outline-none focus:ring-0">
            <svg-loader class="me-1 h-4 w-4 fill-danger" name="icon-trash-can" />
            {{ $t('delete') }}
        </base-menu-button>

        <base-menu-items>
            <base-menu-item
                :disabled="!orphan.transcripts.first_trimester"
                class="w-full whitespace-nowrap"
                @click.prevent="handleDeleteTranscript(orphan.transcripts.first_trimester?.id, close)"
            >
                {{ $t('first_trimester') }}
            </base-menu-item>

            <base-menu-item
                :disabled="!orphan.transcripts.second_trimester"
                class="w-full whitespace-nowrap"
                @click.prevent="handleDeleteTranscript(orphan.transcripts.second_trimester?.id, close)"
            >
                {{ $t('second_trimester') }}
            </base-menu-item>

            <base-menu-item
                :disabled="!orphan.transcripts.third_trimester"
                class="w-full whitespace-nowrap"
                @click.prevent="handleDeleteTranscript(orphan.transcripts.third_trimester?.id, close)"
            >
                {{ $t('third_trimester') }}
            </base-menu-item>
        </base-menu-items>
    </base-menu>
    <!-- End: Delete Transcript-->

    <!-- Begin: Average-->
    <base-popover v-slot="{ close }" class="!z-50 inline-block text-center">
        <base-popover-button as="a" class="flex content-center items-center whitespace-nowrap">
            <svg-loader class="me-1 h-4 w-4 fill-success" name="icon-file-certificate" />

            {{ $t('general_average') }}
        </base-popover-button>
        <base-popover-panel placement="bottom-end">
            <div class="p-2">
                <form @submit.prevent="handleSubmitGeneralAverage(orphan.id, close)">
                    <div>
                        <div class="text-start ltr:text-xs rtl:text-sm rtl:font-semibold">
                            {{ $t('general_average') }}
                        </div>

                        <base-form-input
                            v-model="generalAverage"
                            :placeholder="$t('auth.placeholders.fill', { attribute: $t('general_average') })"
                            class="mt-2 flex-1"
                            max="20"
                            step="0.01"
                            type="number"
                        ></base-form-input>
                    </div>

                    <div class="mt-3 flex items-center">
                        <base-button
                            class="ms-auto w-32"
                            type="button"
                            variant="secondary"
                            @click="
                                () => {
                                    close()
                                }
                            "
                        >
                            {{ $t('cancel') }}
                        </base-button>

                        <base-button class="ms-2 w-32" type="submit" variant="primary"> {{ $t('save') }}</base-button>
                    </div>
                </form>
            </div>
        </base-popover-panel>
    </base-popover>
    <!-- End: Average-->
</template>
