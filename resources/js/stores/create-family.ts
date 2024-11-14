import { CreateFamilyForm } from '@/types/types'

import { defineStore } from 'pinia'

interface State {
    family: CreateFamilyForm
    current_step: number
    total_steps: number
    creating_completed: boolean
    tab_index: number
    step_one_completed: boolean
    step_two_completed: boolean
    step_three_completed: boolean
    step_four_completed: boolean
}

export const useCreateFamilyStore = defineStore('create-family', {
    state: (): State => ({
        current_step: 1,
        total_steps: 5,
        tab_index: 0,
        step_one_completed: false,
        step_two_completed: false,
        step_three_completed: false,
        step_four_completed: false,
        creating_completed: false,
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
                birth_certificate_file: ''
            },
            incomes: {
                cnr: 0,
                cnas: 0,
                casnos: 0,
                pension: 0,
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
                other_income: 0
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
            spouse: {
                first_name: '',
                last_name: '',
                income: 0,
                birth_date: '',
                death_date: '',
                function: '',
                death_certificate_file: ''
            },
            orphans: [
                {
                    first_name: '',
                    last_name: '',
                    birth_date: '',
                    photo: '',
                    family_status: '',
                    health_status: '',
                    academic_level_id: null,
                    vocational_training_id: null,
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
                    gender: 'male'
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
                television: false,
                refrigerator: false,
                fireplace: false,
                washing_machine: false,
                water_heater: false,
                oven: false,
                wardrobe: false,
                cupboard: false,
                covers: false,
                mattresses: false,
                other_furnishings: false
            },
            report: '',
            preview_date: null,
            other_properties: '',
            branch_id: '',
            submitted: false
        }
    })
})
