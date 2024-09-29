import type { AddSchoolLessonType } from '@/types/lessons'

import type { Form } from 'laravel-precognition-vue/dist/types'

import type { HousingType } from '@/Pages/Tenant/families/create/stepFour/HousingForm.vue'

import {
    colorSchemes,
    createFamilyStepOneErrorProps,
    createFamilyStepTwoErrorProps,
    registerStepOneErrorProps,
    registerStepThreeErrorProps,
    registerStepTwoErrorProps
} from '@/utils/constants'

export interface IPlacement {
    placement:
        | 'top-start'
        | 'top'
        | 'top-end'
        | 'right-start'
        | 'right'
        | 'right-end'
        | 'bottom-end'
        | 'bottom'
        | 'bottom-start'
        | 'left-start'
        | 'left'
        | 'left-end'
}

export interface IMenu {
    icon: SVGType
    title: string
    url?: string
    routeName: string
    subMenu?: IMenu[]
    ignore?: boolean
}

export interface IFormattedMenu extends IMenu {
    active?: boolean
    activeDropdown?: boolean
    subMenu?: IFormattedMenu[]
}

export interface ILocation {
    routeName: string
    forceActiveMenu?: string
}

export type AppearanceType = 'light' | 'dark'

export type ColorSchemesType = typeof colorSchemes

export type ThemesType = 'icewall' | 'rubick' | 'enigma' | 'tinker'

export type LayoutsType = 'side_menu' | 'simple_menu' | 'top_menu'

export interface ISettingState {
    appearance: AppearanceType
    colorScheme: ColorSchemesType
    theme: ThemesType
    layout: LayoutsType
    hints: {
        [key: string]: boolean
    }
}

export type SVGType =
    | 'icon-hands-holding-child'
    | 'icon-trash-undo'
    | 'icon-kahatain'
    | 'icon-diapers'
    | 'icon-eye'
    | 'icon-file-certificate'
    | 'icon-trash-list'
    | 'icon-algerian-dinar'
    | 'icon-dollar-sign'
    | 'icon-shirt-long-sleeve'
    | 'icon-shoes'
    | 'icon-stethoscope'
    | 'icon-people-roof'
    | 'icon-briefcase'
    | 'icon-hashtag'
    | 'icon-gender'
    | 'icon-pants'
    | 'icon-bottle-baby'
    | 'icon-box-archive'
    | 'icon-clock'
    | 'icon-brush'
    | 'icon-user'
    | 'icon-baby-carriage'
    | 'icon-check'
    | 'icon-diploma'
    | 'icon-books'
    | 'icon-shelves'
    | 'icon-graduation-cap'
    | 'icon-school-lock'
    | 'icon-chalkboard-user'
    | 'icon-calendar-users'
    | 'icon-angles-up-down'
    | 'icon-bars-filter'
    | 'icon-message-dots'
    | 'icon-right-left-large'
    | 'icon-triangle-exclamation'
    | 'icon-memo-circle-info'
    | 'icon-handshake-angle'
    | 'icon-hands-holding-heart'
    | 'icon-file-lines'
    | 'icon-child-reaching'
    | 'icon-person-dress'
    | 'icon-users-plus'
    | 'icon-note'
    | 'icon-filters'
    | 'icon-filter-list'
    | 'icon-couple'
    | 'icon-notes'
    | 'icon-calendar'
    | 'icon-circle-exclamation'
    | 'icon-circle-question'
    | 'icon-left-from-bracket'
    | 'icon-backpack'
    | 'icon-ram'
    | 'icon-moon-stars'
    | 'icon-moon'
    | 'icon-map-location-dot'
    | 'icon-chart-pie-simple'
    | 'icon-hand-holding-circle-dollar'
    | 'icon-grid-round-2-plus'
    | 'icon-code-merge'
    | 'icon-children'
    | 'icon-user-plus'
    | 'icon-gears'
    | 'icon-calendar-star'
    | 'icon-hands-holding-dollar'
    | 'icon-basket-shopping'
    | 'icon-house'
    | 'icon-users'
    | 'icon-user-lock'
    | 'icon-branches'
    | 'icon-file-export'
    | 'icon-family'
    | 'icon-users-gear'
    | 'icon-circle-nodes'
    | 'icon-file-pdf'
    | 'icon-pen'
    | 'icon-file-excel'
    | 'icon-print'
    | 'icon-square-check'
    | 'icon-arrows-up-down'
    | 'icon-bars-staggered'
    | 'icon-bell'
    | 'icon-check-circle'
    | 'icon-chevron-down'
    | 'icon-chevron-left'
    | 'icon-chevron-right'
    | 'icon-chevrons-left'
    | 'icon-chevrons-right'
    | 'icon-circle-x-mark'
    | 'icon-gear'
    | 'icon-gear-complex'
    | 'icon-image'
    | 'icon-pagination-dots'
    | 'icon-search'
    | 'icon-sort'
    | 'icon-sort-down'
    | 'icon-sort-up'
    | 'icon-spin'
    | 'icon-x'
    | 'icon-x-mark'
    | 'icon-trash-can'
    | 'icon-plus'
    | 'loader-oval'
    | 'no-data'
    | 'no-data-astro'

export interface Wilaya {
    wilaya_code: string
    wilaya_name: string
}

export interface Daira {
    id: number
    wilaya_code: string
    daira_name: string
}

export interface Commune {
    id: number
    commune_name: string
}

export type LangType = 'ar' | 'en' | 'fr'

export type RegisterForm = {
    association: string
    domain: string
    address: string
    city: string
    first_name: string
    last_name: string
    phone: string
    email: string
    password: string
    password_confirmation: string
    association_email: string
    landline: string
    phones: string[]
    ccp: string
    cpa: string
    links: { [key: string]: string }
}

export interface RegistrationStepProps {
    currentStep: number
    totalSteps: number
    form?: Form<RegisterForm>
}

export type RegisterStepOneProps = typeof registerStepOneErrorProps

export type RegisterStepTwoProps = typeof registerStepTwoErrorProps

export type RegisterStepThreeProps = typeof registerStepThreeErrorProps

export interface PaginationData<T> {
    data: Array<T>
    meta: {
        current_page: number
        first_page_url: string
        from: number
        last_page: number
        last_page_url: string
        next_page_url: string | null
        path: string
        per_page: number
        prev_page_url: string | null
        to: number
        total: number
    }
    links: {
        url: string
        label: string
        active: boolean
        next: string
    }
}

export interface Zone {
    id: string
    name: string
    description?: string
}

export interface Branch {
    id: string
    name: string
}

export interface Role {
    uuid: string
    name: string
}

export interface CreateBranchForm {
    name: string
    city_id: string
    president_id: string
    created_at: string
}

export interface CreateRoleForm {
    name: string
    permissions: {
        [key: string]: boolean
    }
}

export interface CreateMemberForm {
    first_name: string
    last_name: string
    email: string
    phone: string
    zone_id: string
    qualification: string
    password: string
    password_confirmation: string
    branch_id: string
    roles: string[]
    gender: 'male' | 'female'
}

export type CreateLessonForm = {
    title: string
    start_date: string
    end_date: string
    school_id: string
    subject_id?: number
    academic_level_id: number | null
    orphans: string[]
    color: string
    until: string
    frequency: 'weekly' | 'monthly' | 'daily' | ''
    interval: number | null
    update_this_and_all_coming: boolean
}

export interface CreateNeedForm {
    demand: string
    subject: string
    status: string
    note: string
    needable_type: 'orphan' | 'sponsor'
    needable_id: string
}

export interface CreateFinancialTransactionForm {
    amount: number | null
    description: string
    date: Date | string
    member_id: string
    type: 'income' | 'expense'
    specification:
        | 'drilling_wells'
        | 'monthly_sponsorship'
        | 'eid_el_adha'
        | 'eid_el_fitr'
        | 'other'
        | 'school_entry'
        | 'analysis'
        | 'therapy'
        | 'ramadan_basket'
}

export interface AddItemToInventoryForm {
    name: string
    qty: number | null
    unit: 'kg' | 'piece' | 'liter'
    type: 'diapers' | 'baby_milk' | string
    note: string
}

export interface FamiliesIndexResource {
    id: string
    name: string
    start_date: Date
    file_number: number
    zone: Zone
    address: string
}

export interface TrashIndexResource {
    id: string
    name: string
    deleted_at: Date
    user_name: string
    type: string
    restore_url: string
    force_delete_url: string
    user_id: string
}

export interface ArchiveIndexResource {
    id: string
    occasion: string
    name: string
    savedBy: {
        id: string
        name: string
    }
    created_at: Date
    readable_created_at: string
    url: string
    families_count: number
}

export interface EidAlAdhaFamiliesResource {
    id: string
    address: string
    zone: {
        id: string
        name: string
    }
    branch: {
        id: string
        name: string
    }
    sponsor: {
        id: string
        name: string
        phone_number: string
    }
    orphans_count: number
    total_income: number
    income_rate: number
}

export interface RamadanBasketFamiliesResource {
    id: string
    address: string
    zone: {
        id: string
        name: string
    }
    branch: {
        id: string
        name: string
    }
    sponsor: {
        id: string
        name: string
        phone_number: string
    }
    orphans_count: number
    total_income: number
    income_rate: number
}

export interface SchoolEntryOrphansResource {
    id: string
    sponsor: {
        id: string
        name: string
        phone_number: string
    }
    family: {
        zone: {
            id: string
            name: string
        }
        address: string
    }
    orphan: {
        id: string
        name: string
        academic_phase: string
        academic_level: string
        last_year_average: string
    }
}

export interface BabiesMilkAndDiapersResource {
    id: string
    sponsor: {
        id: string
        name: string
        phone_number: string
    }
    orphan: {
        id: string
        name: string
        baby_milk_quantity: number
        baby_milk_type: string
        diapers_quantity: number
        diapers_type: string
        age: string
    }
}

export interface EidSuitOrphansResource {
    id: string
    sponsor: {
        id: string
        name: string
        phone_number: string
    }
    family: {
        zone: {
            id: string
            name: string
        }
        address: string
    }
    orphan: {
        id: string
        name: string
        shoes_size: string
        pants_size: string
        shirt_size: string
        age: number
    }
}

export interface InventoryIndexResource {
    id: string
    name: string
    qty: number
    unit: string
    note?: string
    created_at: string
}

export interface OrphansIndexResource {
    id: string
    name: string
    birth_date: string
    family_status: string
    health_status: string
    academic_level: string
    academic_level_phase: string
    shoes_size: string
    pants_size: string
    shirt_size: string
    note?: string
    income: number
}

export interface SponsorsIndexResource {
    id: string
    name: string
    phone_number: string
    birth_date: string
    academic_level: string
    academic_level_phase: string
    function: string
    health_status: string
    sponsor_type: string
}

export interface RolesIndexResource {
    uuid: string
    name: string
    created_at: string
    permissions_count: string
    users_count: string
}

export interface IndexParams {
    perPage: number
    search?: string
    page: number
    fields?: string[]
    directions?: {
        [key: string]: 'asc' | 'desc'
    }
    filters?: {
        field: string
        value: string
        operator: string
    }[]
    archive?: string
}

type SponsorType = {
    first_name: string
    last_name: string
    phone_number: string
    sponsorship_type: string
    birth_date: string
    father_name: string
    mother_name: string
    birth_certificate_number: string
    academic_level_id: number | null
    function: string
    health_status: string
    diploma: string
    card_number: string
    sponsor_type: string
    is_unemployed: boolean
    gender: 'male' | 'female'
    ccp: string
}

type SecondSponsorType = {
    first_name: string
    last_name: string
    phone_number: string
    income: number
    address: string
    degree_of_kinship: string
}

type SpouseType = {
    first_name: string
    last_name: string
    birth_date: string
    death_date: string
    function: string
    income: number
}

export type OrphanType = {
    first_name: string
    last_name: string
    birth_date: string
    family_status: string
    health_status: string
    academic_level_id: number | null
    vocational_training_id: number | null
    shoes_size: string
    pants_size: string
    shirt_size: string
    income: number | null
    note: string
    gender: 'male' | 'female'
    baby_milk_quantity: number
    baby_milk_type: string
    diapers_type: string
    diapers_quantity: number
    is_handicapped: boolean
    is_unemployed: boolean
}

export type IncomeType = {
    cnr: number
    casnos: number
    cnas: number
    pension: number
    other_income: number
    account: number
}

export type FamilySponsorship = 'monthly_allowance' | 'ramadan_basket' | 'zakat' | 'housing_assistance' | 'eid_al_adha'

export type SponsorSponsorship = 'medical_sponsorship' | 'literacy_lessons' | 'direct_sponsorship' | 'project_support'

export type OrphanSponsorship =
    | 'medical_sponsorship'
    | 'university_scholarship'
    | 'association_trips'
    | 'summer_camp'
    | 'eid_suit'
    | 'private_lessons'
    | 'school_bag'

export type FurnishingsType =
    | 'television'
    | 'refrigerator'
    | 'fireplace'
    | 'washing_machine'
    | 'water_heater'
    | 'oven'
    | 'wardrobe'
    | 'cupboard'
    | 'covers'
    | 'mattresses'
    | 'other_furnishings'

export type CreateFamilyForm = {
    address: string
    zone_id: string
    start_date: string
    file_number: string
    sponsor: SponsorType
    incomes: IncomeType
    second_sponsor: SecondSponsorType
    spouse: SpouseType
    orphans: OrphanType[]
    housing: {
        housing_type: {
            name: HousingType
            value: string | number | boolean | null
        }
        number_of_rooms?: number
        housing_receipt_number?: string
    }
    other_properties?: string
    furnishings: Record<FurnishingsType, any> & { notes: { [key in FurnishingsType]?: string } }
    report: string
    submitted: boolean
    preview_date: string
    inspectors_members: string | string[]
    branch_id: string
    family_sponsorship: Record<FamilySponsorship, string | number | null>
    sponsor_sponsorship: Record<SponsorSponsorship, string | number | null>
    orphans_sponsorship: Array<Record<OrphanSponsorship, any>>
}

export type InspectorsMembersType = Array<{ id: string; name: string }>

export type MemberType = { id: string; name: string }

export type MembersType = Array<MemberType>

export interface CreateFamilyStepProps {
    currentStep: number
    totalSteps: number
    members?: InspectorsMembersType
    form?: Form<CreateFamilyForm>
}

export interface FamilyShow {}

export type CreateFamilyStepOneProps = typeof createFamilyStepOneErrorProps

export type CreateFamilyStepTwoProps = typeof createFamilyStepTwoErrorProps

export interface MembersIndexResource {
    id: string
    name: string
    email: string
    phone: string
    zone: Zone
    created_at: Date | string
}

export interface NeedsIndexResource {
    id: string
    demand: string
    subject: string
    status: 'pending' | 'completed' | 'rejected'
    needable: {
        id: string
        type: string
        name: string
    }
    note: string
    created_at: string | Date
    readable_created_at: string
}

export interface FinancialTransactionsIndexResource {
    id: string
    description: string
    amount: number
    date: Date
    specification: string
    creator: {
        id: string
        name: string
    }
    receiver: {
        id: string
        name: string
    }
}

export interface BranchesIndexResource {
    id: string
    name: string
    city?: string
    president?: {
        id: string
        name?: string
    }
    families_count?: string
    created_at: string
}

export interface ZonesIndexResource extends Zone {
    created_at: string
    description: string
    families_count?: number
}

export interface ListBoxFilter {
    field: string
    label: string
    type: 'object' | 'string' | 'date' | 'number'
    icon: SVGType
    operators: Array<ListBoxOperator>
}

export interface ListBoxOperator {
    label: string
    value: string
}

export type FilterValueType = string | { id: string; name: string }

export type FilterValueSponsorshipType = string | { label: string; value: string }

export type ShoesSizesType = { id: number; label: string }[]

export type ClothesSizesType = { id: number; label: string }[]

export type SubjectType = { id: number; name: string }

export type CreateSchoolForm = {
    name: string
    lessons: Array<AddSchoolLessonType>
}

export interface SchoolsIndexResource {
    id: string
    name: string
    quota?: number
    created_at: Date | string
}

export interface DatabaseNotification {
    data: {
        user: {
            id: string
            gender: 'male' | 'female'
            name: string
        }
        metadata: {
            created_at: string
            url: string
            [key: string]: string
        }
        data: object
    }
    type: string
    id: string
    read_at: string
}

export interface RealTimeNotification {
    user: {
        id: string
        gender: 'male' | 'female'
        name: string
    }
    metadata: {
        created_at: string
        url: string
    }
    data: object
    type: string
    id: string
}

export type PopOverPlacementType =
    | 'top-start'
    | 'top'
    | 'top-end'
    | 'right-start'
    | 'right'
    | 'right-end'
    | 'bottom-end'
    | 'bottom'
    | 'bottom-start'
    | 'left-start'
    | 'left'
    | 'left-end'

export type CityType = {
    wilaya_code: string
    wilaya_name: string
    daira_name: string
    id: number
}

export type AuthInformation = {
    email: string
    first_name: string
    last_name: string
    phone: string
    gender: 'male' | 'female'
    address: string
    qualification: string
}

export type ArchiveOccasionType = {
    saved_by: {
        first_name: string
        last_name: string
        id: string
    }
    created_at: string | Date
    id: string
    date?: number | string
}

export type Diaper = {
    id: string
    name: string
}

export type BabyMilk = {
    id: string
    name: string
}

export type SiteSettingsType = {
    association: string
    address: string
    domain: string
    super_admin: {
        id: string
        name: string
    }
    city: CityType
    city_id: string
}

export type NeedStatusType = 'pending' | 'in_progress' | 'completed' | 'rejected'
