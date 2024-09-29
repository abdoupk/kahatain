export type SchoolType = {
    id: string
    name: string
}

export type SubjectType = {
    id: number
    name: string
    academic_level_id: number
    quota: number
}

export interface AddSchoolLessonType {
    academic_level_id: number | null
    quota: number | null
    subject_id: number | null
}

export type EventType = {
    id: string
    title: string
    color: string
    start: string | Date
    end: string | Date
}

export type LevelType = {
    id: number
    name: string
}

export interface AcademicLevelType {
    levels: LevelType[]
    phase: string
}

export interface LessonShowType {
    start_date: string
    end_date: string
    id: string
    subject: {
        id: number
        name: string
    }
    school: {
        id: string
        name: string
    }
    orphans: {
        id: string
        name: string
    }[]
}
