import { PositionType } from '@/types/types'

export interface OrphanType {
    id: string
    name: string
    birth_date: string
    family_status: string
    health_status: string
    academic_level: string
    shoes_size: string
    pants_size: string
    shirt_size: string
    baby_needs?: {
        baby_milk_type: string
        baby_milk_quantity: number
        diapers_type: string
        diapers_quantity: number
    }
    note: string
    gender: string
}

export interface SpouseType {
    id: string
    family_id?: string
    name: string
    birth_date: string
    death_date: string
    death_certificate_file: string
    function: string
    income: string
}

interface IncomeType {
    id: string
    cnr: string
    cnas: string
    casnos: string
    pension: string
    account: string
    other_income: string
    total_income: number
}

export interface SponsorType {
    name: string
    phone_number: string
    sponsor_type: string
    birth_date: string
    father_name: string
    mother_name: string
    birth_certificate_number: string
    academic_level: string
    function: string
    health_status: string
    diploma: string
    card_number: string
    ccp: string
    id: string
    creator: {
        id: string
        name: string
    }
    incomes: IncomeType
}

export interface SecondSponsorType {
    id: string
    family_id?: string
    name: string
    degree_of_kinship: string
    phone_number: string
    address: string
    income: string
}

export interface FurnishingType {
    id: string
    family_id?: string
    television: string
    refrigerator: string
    fireplace: string
    washing_machine: string
    water_heater: string
    oven: string
    wardrobe: string
    cupboard: string
    covers: string
    mattresses: string
    other_furnishings: string
}

export interface HousingType {
    id: string
    family_id?: string
    name: string
    value: string
    housing_receipt_number: string
    number_of_rooms: number
    other_properties: string
}

export interface FamilyEditHousingType {
    id: string
    family_id: string
    housing_type: {
        name: 'independent' | 'with_family' | 'tenant' | 'inheritance' | 'other'
        value: string | number | boolean | null
    }
    housing_receipt_number: string
    number_of_rooms: number
    other_properties: string
}

export interface PreviewType {
    family_id: string
    report: string
    preview_date: string
    inspectors: {
        id: string
        name: string
    }[]
}

export interface FamilyShowType {
    id: string
    name: string
    address: string
    file_number: string
    start_date: Date
    residence: {
        residence_certificate_file: string
        created_at: string
        file_type: string
    }
    branch: string
    zone: string
    orphans: OrphanType[]
    spouse: SpouseType
    sponsor: SponsorType
    second_sponsor: SecondSponsorType
    furnishings: FurnishingType
    housing: HousingType
    preview: PreviewType
}

export interface FamilyEditType {
    id: string
    name: string
    address: string
    file_number: string
    start_date: Date
    branch_id: string
    zone_id: string
    spouse: SpouseType
    second_sponsor: SecondSponsorType
    furnishings: FurnishingType
    residence_certificate_file: string | null
    housing: {
        id: string
        family_id: string
        housing_type: {
            name: string
            value: string
        }
        housing_receipt_number: string
        number_of_rooms: number
        other_properties: string
    }
    family_sponsorships: FamilySponsorshipType
    preview: PreviewType
    creator: {
        id: string
        name: string
    }
}

export interface FamilyUpdateFormType {
    id: string
    name: string
    address: string
    location: PositionType
    file_number: string
    start_date: Date
    branch_id: string
    zone_id: string
    residence_certificate_file: string | null
    spouse: SpouseType
    second_sponsor: SecondSponsorType
    furnishings: FurnishingType
    housing: FamilyEditHousingType
    family_sponsorships: FamilySponsorshipType
    preview: PreviewType
}

export interface FamilyUpdateSpouseFormType {
    id: string
    name: string
    birth_date: string
    death_date: string
    function: string
    income: string
    first_name?: string
    last_name?: string
}

export interface FamilyUpdateSecondSponsorFormType {
    id: string
    family_id?: string
    first_name: string
    last_name: string
    degree_of_kinship: string
    phone_number: string
    address: string
    income: string
    with_family?: boolean
}

export interface FamilyUpdateReportFormType extends FamilyEditPreviewType {}

export interface FamilyUpdateSponsorShipsFormType extends FamilySponsorshipType {}

export interface FamilyUpdateHousingFormType extends HousingType {
    housing_type: {
        name: 'independent' | 'with_family' | 'tenant' | 'inheritance' | 'other'
        value: string | number | boolean | null
    }
}

export interface FamilyUpdateFurnishingFormType extends FurnishingType {}

export interface FamilyEditPreviewType {
    family_id: string
    report: string
    preview_date: string
    inspectors: string | string[]
}

export type FamilyType = {
    id: string
    name: string
}
