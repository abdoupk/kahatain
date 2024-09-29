import type { OrphanSponsorshipType } from '@/types/families'

export interface OrphanShowType {
    id: string
    name: string
    birth_date: string
    family_status: string
    health_status: string
    academic_level: string
    shoes_size: string
    pants_size: string
    shirt_size: string
    note: string
    gender: string
    creator: {
        id: string
        name: string
    }
    sponsorships: OrphanSponsorshipType
    baby_needs: {
        baby_milk_type: string
        baby_milk_quantity: number
        diapers_type: string
        diapers_quantity: number
    }
    academic_achievements: AcademicAchievementsType[]
    last_academic_year_achievement?: string
    college_achievements: CollegeAchievementsType[]
    vocational_training_achievements: VocationalTrainingAchievementsType[]
}

export interface AcademicAchievementsType {
    id: string
    academic_level: string
    first_trimester: number
    second_trimester: number
    third_trimester: number
    average: number
    academic_year: number
    note?: string
}

export interface CollegeAchievementsType {
    id: string
    academic_level: string
    first_semester: number
    second_semester: number
    average: number
    year: number
    speciality?: string
    university?: string
    note?: string
}

export interface VocationalTrainingAchievementsType {
    id: string
    institute: string
    year: number
    note?: string
    speciality?: string
    division?: string
}

export interface CollegeAchievementsType {
    id: string
    academic_level: string
    first_trimester: number
    second_trimester: number
    third_trimester: number
    average: number
    academic_year: number
    note?: string
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
    sponsorships: OrphanSponsorshipType
    baby_milk_type: string
    baby_milk_quantity: number
    diapers_type: string
    diapers_quantity: number
    creator: {
        id: string
        name: string
    }
    academic_achievements: AcademicAchievementsType[]
    last_academic_year_achievement?: string
    college_achievements: CollegeAchievementsType[]
    vocational_training_achievements: VocationalTrainingAchievementsType[]
}
