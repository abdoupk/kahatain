export type CreateAcademicAchievementForm = {
    academic_year: string | null
    first_trimester: number | null
    second_trimester: number | null
    third_trimester: number | null
    average: number | null
    orphan_id: string
    academic_level_id: number | null
    note?: string
}
