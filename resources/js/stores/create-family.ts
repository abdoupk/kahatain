import { CreateFamilyForm, CreateFamilyStepOneProps, CreateFamilyStepTwoProps } from '@/types/types'

import { Form } from 'laravel-precognition-vue/dist/types'
import { defineStore } from 'pinia'

import {
    createFamilyStepFiveErrorProps,
    createFamilyStepFourErrorProps,
    createFamilyStepOneErrorProps,
    createFamilyStepThreeErrorProps,
    createFamilyStepTwoErrorProps
} from '@/utils/constants'
import { checkErrors } from '@/utils/helper'

interface State {
    family: CreateFamilyForm
    current_step: number
    total_steps: number
    creating_completed: boolean
    tab_index: number
    is_dirty: boolean
    step_one_completed: boolean
    step_two_completed: boolean
    step_three_completed: boolean
    step_four_completed: boolean
    validating: boolean
}

export const useCreateFamilyStore = defineStore('create-family', {
    state: (): State => ({
        current_step: 1,
        total_steps: 5,
        tab_index: 0,
        is_dirty: false,
        step_one_completed: false,
        step_two_completed: false,
        step_three_completed: false,
        step_four_completed: false,
        creating_completed: false,
        validating: false,
        family: {
            file_number: '',
            zone_id: '',
            inspectors_members: [],
            address: '',
            location: {
                lat: null,
                lng: null
            },
            start_date: '',
            residence_certificate_file: '',
            sponsor: {
                first_name: '',
                is_unemployed: false,
                last_name: '',
                phone_number: '',
                birth_date: null,
                father_name: '',
                mother_name: '',
                birth_certificate_number: '',
                academic_level: '',
                function: '',
                health_status: '',
                diploma: '',
                card_number: '',
                sponsor_type: '',
                gender: 'male',
                ccp: '',
                photo: '',
                diploma_file: '',
                birth_certificate_file: '',
                no_remarriage_file: ''
            },
            incomes: {
                cnr: false,
                cnas: false,
                casnos: false,
                pension: false,
                bank_file: '',
                ccp_file: '',
                cnr_file: '',
                casnos_file: '',
                cnas_file: '',
                account: {
                    ccp: {
                        monthly_income: null,
                        balance: null,
                        performance_grant: null
                    },
                    bank: {
                        monthly_income: null,
                        balance: null,
                        performance_grant: null
                    }
                },
                other_income: null
            },
            second_sponsor: {
                first_name: '',
                last_name: '',
                phone_number: '',
                income: '',
                address: '',
                degree_of_kinship: '',
                with_family: false
            },
            deceased: [
                {
                    first_name: '',
                    last_name: '',
                    income: 0,
                    birth_date: '',
                    death_date: '',
                    function: '',
                    death_certificate_file: '',
                    type: ''
                }
            ],
            orphans: [
                {
                    first_name: '',
                    last_name: '',
                    birth_date: '',
                    photo: '',
                    family_status: '',
                    health_status: '',
                    academic_level_id: null,
                    institution_id: null,
                    shoes_size: '',
                    pants_size: '',
                    shirt_size: '',
                    baby_milk_quantity: '',
                    baby_milk_type: '',
                    diapers_quantity: '',
                    diapers_type: '',
                    note: '',
                    income: null,
                    is_handicapped: false,
                    is_unemployed: false,
                    gender: 'male',
                    ccp: null,
                    phone_number: null,
                    institution_type: null,
                    speciality_id: null,
                    speciality_type: null
                }
            ],
            housing: {
                housing_type: {
                    value: true,
                    name: 'independent'
                },
                housing_receipt_number: '',
                number_of_rooms: 0
            },
            furnishings: {
                television: {
                    checked: false,
                    note: ''
                },
                refrigerator: {
                    checked: false,
                    note: ''
                },
                fireplace: {
                    checked: false,
                    note: ''
                },
                washing_machine: {
                    checked: false,
                    note: ''
                },
                water_heater: {
                    checked: false,
                    note: ''
                },
                oven: {
                    checked: false,
                    note: ''
                },
                wardrobe: {
                    checked: false,
                    note: ''
                },
                cupboard: {
                    checked: false,
                    note: ''
                },
                covers: {
                    checked: false,
                    note: ''
                },
                mattresses: {
                    checked: false,
                    note: ''
                },
                other_furnishings: {
                    checked: false,
                    note: ''
                }
            },
            report: '',
            preview_date: null,
            other_properties: '',
            branch_id: '',
            submitted: false
        }
    }),
    actions: {
        async validateStepOne(form: Form<CreateFamilyForm>) {
            await this.validateStep(form, createFamilyStepOneErrorProps, 'step_one_completed').finally(() => {
                if (this.step_one_completed) {
                    this.forgetErrors(form, createFamilyStepTwoErrorProps)

                    this.current_step = 2

                    this.tab_index = 0
                }
            })
        },
        async validateStepTwo(form: Form<CreateFamilyForm>) {
            await this.validateStep(form, createFamilyStepTwoErrorProps, 'step_two_completed').finally(() => {
                if (this.tab_index === 0 && !checkErrors('^sponsor.+', form.errors)) {
                    this.tab_index = 1
                } else if (this.tab_index === 1 && !checkErrors('^income', form.errors)) {
                    this.tab_index = 2
                } else if (this.tab_index === 2 && !checkErrors('^second_sponsor', form.errors)) {
                    this.tab_index = 3
                } else if (this.isStepTwoCompleted(form.errors)) {
                    this.step_two_completed = true

                    this.current_step = 3

                    this.forgetErrors(form, createFamilyStepThreeErrorProps)
                }
            })
        },
        async validateStepThree(form: Form<CreateFamilyForm>) {
            await this.validateStep(form, createFamilyStepThreeErrorProps, 'step_three_completed').finally(() => {
                if (this.step_two_completed && this.step_three_completed) {
                    this.current_step = 4

                    this.tab_index = 0

                    this.forgetErrors(form, createFamilyStepFourErrorProps)
                }
            })
        },
        async validateStepFour(form: Form<CreateFamilyForm>) {
            await this.validateStep(form, createFamilyStepFourErrorProps, 'step_four_completed').finally(() => {
                if (
                    this.step_one_completed &&
                    this.step_two_completed &&
                    this.step_three_completed &&
                    this.step_four_completed &&
                    this.tab_index === 2
                ) {
                    this.forgetErrors(form, createFamilyStepFiveErrorProps)

                    this.current_step = 5

                    this.step_four_completed = true
                } else if (this.tab_index === 0 && !checkErrors('^housing', form.errors)) {
                    this.tab_index = 1
                } else if (this.tab_index === 1 && !checkErrors('^furnishings', form.errors)) {
                    this.tab_index = 2
                } else if (
                    this.tab_index === 3 &&
                    !checkErrors('^housing', form.errors) &&
                    !checkErrors('^furnishings', form.errors) &&
                    !checkErrors('other_properties$', form.errors)
                ) {
                    this.forgetErrors(form, createFamilyStepFiveErrorProps)

                    this.current_step = 5

                    this.step_four_completed = true
                }
            })
        },
        isStepTwoCompleted(errors: Record<string, string>) {
            return (
                this.tab_index === 3 &&
                !checkErrors('^spouse', errors) &&
                !checkErrors('^second_sponsor', errors) &&
                !checkErrors('^sponsor.+', errors) &&
                !checkErrors('^income', errors)
            )
        },
        forgetErrors(form: Form<CreateFamilyForm>, errors: CreateFamilyStepTwoProps[] | null) {
            errors.forEach((prop: CreateFamilyStepTwoProps) => {
                const regex = prop === 'address' ? new RegExp(`^${prop}$`) : new RegExp(prop)

                Object.keys(form.errors).forEach((error) => {
                    if (regex.test(error)) {
                        form.forgetError(error as keyof CreateFamilyForm)
                    }
                })
            })
        },
        checkErrors(
            form: Form<CreateFamilyForm>,
            errorProps: CreateFamilyStepOneProps[] | CreateFamilyStepTwoProps[],
            step: string
        ) {
            const errors: string[] = []

            errorProps.forEach((prop) => {
                const regex = prop === 'address' ? new RegExp(`^${prop}$`) : new RegExp(prop)

                Object.keys(form.errors).forEach((error) => {
                    if (regex.test(error)) {
                        errors.push(form.errors[error as keyof CreateFamilyForm])
                    }
                })
            })

            this[step] = errors.length === 0 && !form.validating
        },
        handleClickToNextStep(form: Form<CreateFamilyForm>, index: number) {
            if (index === 2) {
                this.checkErrors(form, createFamilyStepOneErrorProps, 'step_one_completed')

                if (this.step_one_completed) this.current_step = 2
            } else if (index === 3) {
                this.checkErrors(form, createFamilyStepOneErrorProps, 'step_one_completed')

                this.checkErrors(form, createFamilyStepTwoErrorProps, 'step_two_completed')

                if (this.step_one_completed && this.step_two_completed) this.current_step = 3
            } else if (index === 4) {
                this.checkErrors(form, createFamilyStepOneErrorProps, 'step_one_completed')

                this.checkErrors(form, createFamilyStepTwoErrorProps, 'step_two_completed')

                this.checkErrors(form, createFamilyStepThreeErrorProps, 'step_three_completed')

                if (this.step_one_completed && this.step_two_completed && this.step_three_completed)
                    this.current_step = 4
            } else if (index === 5) {
                this.checkErrors(form, createFamilyStepOneErrorProps, 'step_one_completed')

                this.checkErrors(form, createFamilyStepTwoErrorProps, 'step_two_completed')

                this.checkErrors(form, createFamilyStepThreeErrorProps, 'step_three_completed')

                this.checkErrors(form, createFamilyStepFourErrorProps, 'step_four_completed')

                if (
                    this.step_one_completed &&
                    this.step_two_completed &&
                    this.step_three_completed &&
                    this.step_four_completed
                )
                    this.current_step = 5
            }
        }
    },
    getters: {
        validateStep:
            (state) =>
            async (
                form: Form<CreateFamilyForm>,
                errorProps: CreateFamilyStepOneProps[] | CreateFamilyStepTwoProps[],
                step: string
            ) => {
                state.validating = true

                await form.submit({
                    onFinish() {
                        state.checkErrors(form, errorProps, step)

                        state.validating = false
                    }
                })
            }
    }
})
