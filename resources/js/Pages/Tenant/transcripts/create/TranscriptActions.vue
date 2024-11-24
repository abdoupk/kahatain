<script setup lang="ts">
import { OrphansTranscriptsIndexResource } from '@/types/types'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseMenu from '@/Components/Base/headless/Menu/BaseMenu.vue'
import BaseMenuButton from '@/Components/Base/headless/Menu/BaseMenuButton.vue'
import BaseMenuItem from '@/Components/Base/headless/Menu/BaseMenuItem.vue'
import BaseMenuItems from '@/Components/Base/headless/Menu/BaseMenuItems.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    orphan: OrphansTranscriptsIndexResource
    shouldCreateFirstTrimesterTranscript: boolean
    shouldCreateSecondTrimesterTranscript: boolean
    shouldCreateThirdTrimesterTranscript: boolean
}>()

const emit = defineEmits(['showCreateModal', 'showEditModal'])

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
</script>

<template>
    <!-- Begin: Create Transcript-->
    <base-menu v-slot="{ close }">
        <base-menu-button class="w-full border-0 shadow-none focus:outline-none focus:ring-0" :as="BaseButton">
            <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-plus"></svg-loader>

            {{ $t('create') }}
        </base-menu-button>

        <base-menu-items>
            <base-menu-item
                class="w-full whitespace-nowrap"
                @click.prevent="handleCreateTranscript('first_trimester', orphan, close)"
                :disabled="!shouldCreateFirstTrimesterTranscript || orphan.transcripts.first_trimester"
            >
                {{ $t('first_trimester') }}
            </base-menu-item>

            <base-menu-item
                class="w-full whitespace-nowrap"
                @click.prevent="handleCreateTranscript('second_trimester', orphan, close)"
                :disabled="!shouldCreateSecondTrimesterTranscript || orphan.transcripts.second_trimester"
            >
                {{ $t('second_trimester') }}
            </base-menu-item>

            <base-menu-item
                class="w-full whitespace-nowrap"
                @click.prevent="handleCreateTranscript('third_trimester', orphan, close)"
                :disabled="!shouldCreateThirdTrimesterTranscript || orphan.transcripts.third_trimester"
            >
                {{ $t('third_trimester') }}
            </base-menu-item>
        </base-menu-items>
    </base-menu>
    <!-- End: Create Transcript-->

    <!-- Begin: Update Transcript-->
    <base-menu v-slot="{ close }">
        <base-menu-button class="-ms-1 w-full border-0 shadow-none focus:outline-none focus:ring-0" :as="BaseButton">
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
</template>
