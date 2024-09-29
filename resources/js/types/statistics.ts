import type { FinancialReportsType } from '@/types/dashboard'

export type FamiliesByZoneType = {
    labels: string[]
    data: number[]
}

export type FamiliesByBranchType = {
    labels: string[]
    data: number[]
}

export type FamiliesByOrphansCountType = {
    total_families: number[]
    orphans_count: number[]
}

export type FamiliesSponsorShipsType = {
    ramadan_basket_count: number
    zakat_count: number
    housing_assistance_count: number
    eid_al_adha_count: number
}

export type FamiliesHousingType = {
    data: number[]
    labels: string[]
}

export type FamiliesGroupByDateType = number[]

export type OrphansByFamilyStatusType = {
    labels: string[]
    data: number[]
}

export type OrphansByAcademicLevelType = {
    labels: string[]
    data: number[]
}

export type OrphansBySponsorshipType = number[]

export type OrphansByGenderType = {
    labels: string[]
    data: number[]
}

export type OrphansByAgeType = {
    age: string[]
    data: number[]
}

export type OrphansByZoneType = {
    labels: string[]
    data: number[]
}

export type OrphansByBranchType = {
    labels: string[]
    data: number[]
}

export type OrphansByPantsAndShirtSizeType = {
    labels: string[]
    pants_data: number[]
    shirts_data: number[]
}

export type OrphansByShoeSizeType = {
    labels: string[]
    data: number[]
}

export type OrphansByVocationalTrainingType = {
    labels: string[]
    data: number[]
}

export type OrphansByCreatedDateType = number[]

export type OrphansGroupHealthStatusType = {
    labels: string[]
    data: number[]
}

export type SponsorsBySponsorTypeType = {
    data: number[]
    labels: string[]
}

export type SponsorsByAcademicLevelType = {
    labels: string[]
    data: number[]
}

export type SponsorsBySponsorshipType = number[]

export type SponsorsByDiplomaType = {
    labels: string[]
    data: number[]
}

export type FinancesBySpecificationType = {
    incomes: {
        [key: string]: number
    }
    expenses: {
        [key: string]: number
    }
}
export type FinancesByTypeType = {
    incomes: number[]
    expenses: number[]
}

export type FinancesByMonthType = FinancialReportsType
