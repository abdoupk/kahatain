import type {
    AppearanceType,
    ColorSchemesType,
    DatabaseNotification,
    LayoutsType,
    PaginationData,
    PositionType,
    ThemesType
} from '@/types/types'

import { Config } from 'ziggy-js'

export interface User {
    id: number
    first_name: string
    last_name: string
    gender?: 'male' | 'female'
    email: string
    email_verified_at: string
    roles: string[]
    tenant_id: string
    permissions: string[]
}

export interface UserSettings {
    layout: LayoutsType
    color_scheme: ColorSchemesType
    theme: ThemesType
    appearance: AppearanceType
    notifications: {
        families_changes: boolean
        branches_and_zones_changes: boolean
        schools_and_lessons_changes: boolean
        occasions_saves: boolean
        financial_changes: boolean
        association_changes: boolean
    }
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User
        settings: UserSettings
        notifications: PaginationData<DatabaseNotification>
    }
    association: string
    association_coordinates: PositionType
    ziggy: Config & { location: string }
}

export type BenefactorType = {
    id: string
    name: string
}
