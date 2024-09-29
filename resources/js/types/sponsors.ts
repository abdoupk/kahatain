import type { SponsorSponsorshipType } from '@/types/families'
import type { IncomeType, Zone } from '@/types/types'

export interface SponsorShowType {
    id: string
    zone: Zone
    branch: {
        id: string
        name: string
    }
    file_number: string
    start_date: Date
    name: string
    address: string
    phone_number: string
    sponsor_type: string
    birth_date: Date
    father_name: string
    mother_name: string
    academic_level: string
    function: string
    health_status: string
    diploma: string
    ccp: string
    gender: 'male' | 'female'
    orphans_count: number
    birth_certificate_number: string
    card_number: string
    incomes: IncomeType
    sponsorships: SponsorSponsorshipType
    creator: {
        id: string
        name: string
    }
}

export interface SponsorUpdateFormType {
    id: string
    first_name: string
    last_name: string
    phone_number: string
    sponsor_type: string
    birth_date: string | Date
    father_name: string
    mother_name: string
    birth_certificate_number: string
    academic_level_id: string
    function: string
    health_status: string
    diploma: string
    card_number: string
    ccp: string
    gender: 'male' | 'female'
    creator: {
        id: string
        name: string
    }
    incomes: IncomeType
    sponsorships: SponsorSponsorshipType
}
