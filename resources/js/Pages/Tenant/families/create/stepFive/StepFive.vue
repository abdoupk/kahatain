<script lang="ts" setup>
import type { CreateFamilyStepProps } from '@/types/types'

import { useCreateFamilyStore } from '@/stores/create-family'
import { useMembersStore } from '@/stores/members'
import { onMounted, ref } from 'vue'

import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseClassicEditor from '@/Components/Base/editor/BaseClassicEditor.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { $t } from '@/utils/i18n'

defineProps<CreateFamilyStepProps>()

const createFamilyStore = useCreateFamilyStore()

const vueSelectInspectorsMembers = ref([])

onMounted(async () => {
    await useMembersStore().getMembers()

    vueSelectInspectorsMembers.value = useMembersStore().findMembersByIds(createFamilyStore.family.inspectors_members)
})
</script>

<template>
    <div
        v-if="createFamilyStore.current_step === 5"
        class="mt-10 border-t border-slate-200/60 px-5 pt-10 dark:border-darkmode-400 sm:px-20"
    >
        <div class="mb-6 hidden text-lg font-medium lg:block rtl:font-bold">
            {{ $t('families.create_family.stepFive') }}
        </div>

        <div class="mt-5 grid grid-cols-12 gap-4 gap-y-5">
            <div class="col-span-12">
                <base-form-label for="report">
                    {{ $t('the_report') }}
                </base-form-label>

                <base-classic-editor
                    id="report"
                    v-model="createFamilyStore.family.report"
                    @blur="form?.validate('report')"
                ></base-classic-editor>

                <base-form-input-error :form field_name="report"></base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-8">
                <base-form-label for="inspectors_members">
                    {{ $t('inspectors_members') }}
                </base-form-label>

                <div>
                    <base-vue-select
                        v-model="vueSelectInspectorsMembers"
                        :options="members ?? []"
                        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('inspectors_members') })"
                        label="name"
                        multiple
                        track-by="name"
                        @update:value="
                            (value) => {
                                // @ts-ignore
                                createFamilyStore.family.inspectors_members = value.map((member) => member.id)

                                form?.validate('inspectors_members')
                            }
                        "
                    ></base-vue-select>
                </div>

                <base-form-input-error :form field_name="inspectors_members"> </base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-4">
                <base-form-label for="preview_date">
                    {{ $t('preview_date') }}
                </base-form-label>

                <base-v-calendar
                    id="preview_date"
                    v-model:date="createFamilyStore.family.preview_date"
                ></base-v-calendar>

                <base-form-input-error :form field_name="preview_date"> </base-form-input-error>
            </div>
        </div>

        <slot></slot>
    </div>
</template>
