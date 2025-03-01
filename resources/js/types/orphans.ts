export interface OrphanShowType {
    id: string
    name: string
    birth_date: string
    family_status: string
    health_status: string
    academic_level: string
    speciality: string
    institution: string
    shoes_size: string
    pants_size: string
    shirt_size: string
    note: string
    gender: string
    income: number | null
    income_rate: number | null
    is_handicapped: boolean
    is_unemployed: boolean
    phone_number: string
    ccp: string
    creator: {
        id: string
        name: string
    }
    baby_needs: {
        baby_milk_type: string
        baby_milk_quantity: number
        diapers_type: string
        diapers_quantity: number
    }
}

export interface OrphanUpdateFormType {
    id: string
    first_name: string
    last_name: string
    birth_date: string
    family_status: string
    health_status: string
    academic_level_id: string
    shoes_size: string
    pants_size: string
    shirt_size: string
    note: string
    gender: string
    baby_milk_type: string
    baby_milk_quantity: number
    diapers_type: string
    diapers_quantity: number
    creator: {
        id: string
        name: string
    }
    income: number | null
    photo: string
    ccp: string
    phone_number: string
    vocational_training_id: string
    speciality_type: string
    speciality_id: number
    vocational_training: {
        id: string
        name: string
    }
    institution_id: string
    institution_type: string
    institution: {
        id: string
        name: string
    }
    speciality: {
        id: string
        name: string
    }
    is_handicapped: boolean
    is_unemployed: boolean
}

export type StudentsPerPhase = {
    phase: string
    total: number
}[]

export type StudentsPerInstitution = {
    phase: string
    total: number
}[]
