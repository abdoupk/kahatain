<script lang="ts" setup>
import type { SponsorSponsorship } from '@/types/types'

import { ref } from 'vue'

import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'

const emit = defineEmits(['update:sponsorSponsorship'])

const items = ref<Record<SponsorSponsorship, boolean>>({
    medical_sponsorship: false,
    literacy_lessons: false,
    direct_sponsorship: false,
    project_support: false
})

const medicalSponsorship = defineModel('medicalSponsorship')

const literacyLessons = defineModel('literacyLessons')

const directSponsorship = defineModel('directSponsorship')

const projectSupport = defineModel('projectSupport')

const toggle = (key: SponsorSponsorship) => {
    items.value[key] = !items.value[key]

    emit('update:sponsorSponsorship', items.value)
}
</script>

<template>
    <div class="mt-6 grid grid-cols-12 gap-4 gap-y-5">
        <!-- Begin: monthly Allowance -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="medical_sponsorship"
                            type="checkbox"
                            @change="toggle('medical_sponsorship')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="medical_sponsorship">
                            {{ $t('sponsorships.medical_sponsorship') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="medicalSponsorship"
                        :disabled="!items.medical_sponsorship"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: monthly Allowance -->

        <!-- Begin: monthly Allowance -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="literacy_lessons"
                            type="checkbox"
                            @change="toggle('literacy_lessons')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="literacy_lessons">
                            {{ $t('sponsorships.literacy_lessons') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="literacyLessons"
                        :disabled="!items.literacy_lessons"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: monthly Allowance -->

        <!-- Begin: monthly Allowance -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="direct_sponsorship"
                            type="checkbox"
                            @change="toggle('direct_sponsorship')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="direct_sponsorship">
                            {{ $t('sponsorships.direct_sponsorship') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="directSponsorship"
                        :disabled="!items.direct_sponsorship"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: monthly Allowance -->

        <!-- Begin: monthly Allowance -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-4">
                    <base-form-switch class="text-lg">
                        <base-form-switch-input
                            id="project_support"
                            type="checkbox"
                            @change="toggle('project_support')"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="project_support">
                            {{ $t('sponsorships.project_support') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                    <base-form-text-area
                        v-model="projectSupport"
                        :disabled="!items.project_support"
                        :placeholder="$t('notes')"
                        class="w-full md:w-3/4"
                        rows="4"
                    ></base-form-text-area>
                </div>
            </div>
        </div>
        <!-- End: monthly Allowance -->
    </div>
</template>
