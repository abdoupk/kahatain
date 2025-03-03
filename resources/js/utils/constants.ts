import type {
    ColorSchemesType,
    CreateFamilyForm,
    CreateFamilyStepOneProps,
    CreateFamilyStepTwoProps,
    IPlacement,
    LayoutsType,
    RegisterStepOneProps,
    RegisterStepThreeProps,
    RegisterStepTwoProps,
    ThemesType
} from '@/types/types'

import { $t } from '@/utils/i18n'

export const placementClasses: Record<IPlacement['placement'], string> = {
    'top-start': 'start-0 bottom-[100%]',
    top: 'start-[50%] translate-x-[-50%] bottom-[100%]',
    'top-end': 'end-0 bottom-[100%]',
    'right-start': 'start-[100%] translate-y-[-50%]',
    right: 'start-[100%] top-[50%] translate-y-[-50%]',
    'right-end': 'start-[100%] bottom-0',
    'bottom-end': 'top-[100%] end-0',
    bottom: 'top-[100%] start-[50%] translate-x-[-50%]',
    'bottom-start': 'top-[100%] start-0',
    'left-start': 'end-[100%] translate-y-[-50%]',
    left: 'end-[100%] top-[50%] translate-y-[-50%]',
    'left-end': 'end-[100%] bottom-0'
}

// eslint-disable-next-line
export const colorSchemes: ColorSchemesType[] = ['default', 'theme_1', 'theme_2', 'theme_3', 'theme_4']

// eslint-disable-next-line
export const layouts: LayoutsType[] = ['side_menu', 'simple_menu', 'top_menu']

// eslint-disable-next-line
export const themes: ThemesType[] = ['enigma', 'icewall', 'tinker', 'rubick']

export const createFamilyFormAttributes: CreateFamilyForm = {
    file_number: '',
    zone_id: '',
    inspectors_members: [],
    address: '',
    location: {
        lat: null,
        lng: null
    },
    start_date: null,
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
        ccp: ''
    },
    incomes: {
        cnr: 0,
        cnas: 0,
        casnos: 0,
        pension: 0,
        account: 0,
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
        function: ''
    },
    orphans: [
        {
            first_name: '',
            last_name: '',
            birth_date: '',
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
    preview_date: new Date(),
    other_properties: '',
    branch_id: '',
    family_sponsorship: {
        monthly_allowance: null,
        ramadan_basket: true,
        zakat: null,
        housing_assistance: null,
        eid_al_adha: true
    },
    sponsor_sponsorship: {
        medical_sponsorship: null,
        literacy_lessons: null,
        direct_sponsorship: null,
        project_support: null
    },
    orphans_sponsorship: [
        {
            medical_sponsorship: true,
            university_scholarship: true,
            association_trips: true,
            summer_camp: true,
            eid_suit: true,
            private_lessons: true,
            school_bag: true
        }
    ],
    submitted: false
}

// eslint-disable-next-line array-element-newline
export const registerStepOneErrorProps: RegisterStepOneProps[] = ['association', 'domain', 'address', 'city']

// eslint-disable-next-line array-element-newline
export const registerStepTwoErrorProps: RegisterStepTwoProps[] = [
    'email',
    'first_name',
    'last_name',
    'phone',
    'password_confirmation',
    'password'
]

// eslint-disable-next-line array-element-newline
export const registerStepThreeErrorProps: RegisterStepThreeProps[] = [
    'association_email',
    'landline',
    'phones.0',
    'cpa',
    'ccp',
    'links'
]
export const createFamilyStepsTitles = [
    'families.create_family.stepOne',
    'families.create_family.stepTwo',
    'families.create_family.stepThree',
    'families.create_family.stepFour',
    'families.create_family.stepFive'
]

export const createFamilyStepOneErrorProps: CreateFamilyStepOneProps[] = [
    'file_number',
    'address',
    'zone',
    'start_date'
]

export const createFamilyStepTwoErrorProps: CreateFamilyStepTwoProps = ['sponsor', 'second_sponsor', 'spouse']

export const createFamilyStepThreeErrorProps = ['orphans']

export const createFamilyStepFourErrorProps = ['housing', 'furnishings']

export const createFamilyStepFiveErrorProps = ['report', 'preview_date', 'inspectors_members']

export const needStatuses = [
    {
        label: $t('pending'),
        value: 'pending'
    },
    {
        label: $t('in_progress'),
        value: 'in_progress'
    },
    {
        label: $t('completed'),
        value: 'completed'
    },
    {
        label: $t('rejected'),
        value: 'rejected'
    }
]

export const financialTransactionSpecifications = [
    {
        label: $t('drilling_wells'),
        value: 'drilling_wells'
    },
    {
        label: $t('monthly_sponsorship'),
        value: 'monthly_sponsorship'
    },
    {
        label: $t('eid_el_adha'),
        value: 'eid_el_adha'
    },
    {
        label: $t('zakat_el_fitr'),
        value: 'zakat_el_fitr'
    },
    {
        label: $t('school_entry'),
        value: 'school_entry'
    },
    {
        label: $t('analysis'),
        value: 'analysis'
    },
    {
        label: $t('zakat'),
        value: 'zakat'
    },
    {
        label: $t('therapy'),
        value: 'therapy'
    },
    {
        label: $t('ramadan_basket'),
        value: 'ramadan_basket'
    },
    {
        label: $t('other'),
        value: 'other'
    }
]

export const permissions = {
    roles: ['create', 'delete', 'list', 'update'],
    members: ['create', 'delete', 'list', 'update', 'view'],
    branches: ['create', 'delete', 'list', 'update', 'view'],
    families: ['create', 'delete', 'export', 'list', 'update', 'view'],
    orphans: ['delete', 'export', 'list', 'update', 'view'],
    sponsors: ['delete', 'export', 'list', 'update', 'view'],
    zones: ['create', 'delete', 'list', 'update', 'view'],
    financial_transactions: ['create', 'delete', 'export', 'list', 'update', 'view'],
    inventory: ['add_to_inventory', 'delete_from_inventory', 'list_items', 'update_inventory', 'view_item'],
    settings: ['update', 'view'],
    occasions: ['save', 'view', 'export'],
    needs: ['create', 'delete', 'list', 'update', 'view'],
    schools: ['create', 'delete', 'list', 'update', 'view', 'print'],
    lessons: ['create', 'delete', 'list', 'update', 'view'],
    archive: ['export', 'list', 'view'],
    trash: ['destroy', 'list', 'restore'],
    committees: ['create', 'delete', 'list', 'update', 'view'],
    benefactors: ['create', 'delete', 'list', 'update', 'view', 'add_new_sponsorship'],
    sponsorships: ['create'],
    transcripts: ['create', 'delete', 'list', 'update', 'view'],
    students: ['list_students', 'start_new_academic_year', 'export_school_supplies', 'view_transcripts_students'],
    college_students: ['list'],
    trainees_orphans: ['list'],
    monthly_sponsorships: ['update_settings', 'update_monthly_basket'],
    ramadan_baskets: ['update_settings', 'update_ramadan_basket']
}

const monthAbbreviationsFrench = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec']

const monthAbbreviationsEnglish = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']

const monthAbbreviationsArabic = [
    'جانفي',
    'فيفري',
    'مارس',
    'أفريل',
    'ماي',
    'جوان',
    'جويلية',
    'أوت',
    'سبتمبر',
    'أكتوبر',
    'نوفمبر',
    'ديسمبر'
]

export const abbreviationMonths = {
    en: monthAbbreviationsEnglish,
    ar: monthAbbreviationsArabic,
    fr: monthAbbreviationsFrench
}

export const colorPalette = {
    dark: [
        '#aacde2',
        '#3574b3',
        '#b1e28c',
        '#35a32f',
        '#f79b9b',
        '#dd1f27',
        '#f8c273',
        '#f98320',
        '#cab0d6',
        '#6c3399',
        '#fcff9c',
        '#ad5b2e'
    ],
    light: [
        '#aacde2',
        '#3574b3',
        '#b1e28c',
        '#35a32f',
        '#f79b9b',
        '#dd1f27',
        '#f8c273',
        '#f98320',
        '#cab0d6',
        '#6c3399',
        '#fcff9c',
        '#ad5b2e'
    ]
}
export const financialSpecifications = [
    'drilling_wells',
    'monthly_sponsorship',
    'eid_el_adha',
    'eid_el_fitr',
    'other',
    'school_entry',
    'analysis',
    'therapy',
    'ramadan_basket'
]
