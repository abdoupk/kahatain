<script setup lang="ts">
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BasePopover from '@/Components/Base/headless/Popover/BasePopover.vue'
import BasePopoverButton from '@/Components/Base/headless/Popover/BasePopoverButton.vue'
import BasePopoverPanel from '@/Components/Base/headless/Popover/BasePopoverPanel.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    loading: boolean
}>()

const emit = defineEmits(['save'])
</script>

<template>
    <div class="text-center">
        <base-popover class="inline-block" v-slot="{ close }">
            <base-popover-button :as="BaseButton" variant="primary">
                {{ $t('save') }}

                <svg-loader name="icon-chevron-down" class="ms-2 h-4 w-4"></svg-loader>
            </base-popover-button>

            <base-popover-panel placement="bottom-start">
                <div class="p-2">
                    <div>
                        <div class="text-start text-xs">From</div>

                        <base-form-input
                            type="text"
                            class="mt-2 flex-1"
                            placeholder="example@gmail.com"
                        ></base-form-input>
                    </div>

                    <div class="mt-3">
                        <div class="text-start text-xs">To</div>

                        <base-form-input
                            type="text"
                            class="mt-2 flex-1"
                            placeholder="example@gmail.com"
                        ></base-form-input>
                    </div>
                    <div class="mt-3 flex items-center">
                        <base-button variant="secondary" @click="close()" class="ms-auto w-32"> Close</base-button>

                        <base-button variant="primary" class="ms-2 w-32" @click.prevent="emit('save')">
                            Search
                        </base-button>
                    </div>
                </div>
            </base-popover-panel>
        </base-popover>
    </div>
</template>
