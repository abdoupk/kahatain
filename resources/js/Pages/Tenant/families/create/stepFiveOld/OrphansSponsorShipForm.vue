<script lang="ts" setup>
import type { CreateFamilyForm, OrphanSponsorship } from '@/types/types'

import type { Form } from 'laravel-precognition-vue/dist/types'
import { computed, ref } from 'vue'

import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'

import { $t } from '@/utils/i18n'

const props = defineProps<{ index: number; form: Form<CreateFamilyForm> }>()

const emit = defineEmits(['update:orphansSponsorship'])

const items = ref<Record<OrphanSponsorship, boolean>>({
    medical_sponsorship: false,
    university_scholarship: false,
    association_trips: false,
    summer_camp: false,
    eid_suit: false,
    private_lessons: false,
    school_bag: false
})

const toggle = (key: OrphanSponsorship) => {
    items.value[key] = !items.value[key]

    emit('update:orphansSponsorship', items.value)
}

const childName = computed(() => {
    return $t('the_child :', {
        name: `${props.form.data().orphans[props.index]?.first_name} ${props.form.data().orphans[props.index]?.last_name}`
    })
})
</script>

<template>
    <div class="my-5 flex">
        <p class="text-base font-medium">
            {{ childName }}
        </p>
    </div>

    <div class="mt-6 grid grid-cols-12 gap-4 gap-y-5 border-2 border-dashed px-2 pb-2.5 pt-2">
        <!-- Begin: medical sponsorship -->
        <div class="intro-y col-span-12">
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
        <!-- End: medical sponsorship -->

        <!-- Begin: university scholarship -->
        <div class="intro-y col-span-12">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="university_scholarship"
                    type="checkbox"
                    @change="toggle('university_scholarship')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="university_scholarship">
                    {{ $t('sponsorships.university_scholarship') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
        <!-- End: university scholarship -->

        <!-- Begin: university trips -->
        <div class="intro-y col-span-12">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="association_trips"
                    type="checkbox"
                    @change="toggle('association_trips')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="association_trips">
                    {{ $t('sponsorships.association_trips') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
        <!-- End: university trips -->

        <!-- Begin: summer camp -->
        <div class="intro-y col-span-12">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="summer_camp"
                    type="checkbox"
                    @change="toggle('summer_camp')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="summer_camp">
                    {{ $t('sponsorships.summer_camp') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
        <!-- End: summer camp -->

        <!-- Begin: eid suit -->
        <div class="intro-y col-span-12">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="eid_suit"
                    type="checkbox"
                    @change="toggle('eid_suit')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="eid_suit">
                    {{ $t('sponsorships.eid_suit') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
        <!-- End: eid suit -->

        <!-- Begin: university trips -->
        <div class="intro-y col-span-12">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="association_trips"
                    type="checkbox"
                    @change="toggle('association_trips')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="association_trips">
                    {{ $t('sponsorships.association_trips') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
        <!-- End: university trips -->

        <!-- Begin: university scholarship -->
        <div class="intro-y col-span-12">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="university_scholarship"
                    type="checkbox"
                    @change="toggle('university_scholarship')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="university_scholarship">
                    {{ $t('sponsorships.university_scholarship') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
        <!-- End: university scholarship -->
    </div>
</template>
