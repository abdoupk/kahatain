export type CreateCollegeAchievementForm = {
    year: string | null
    first_semester: number | null
    second_semester: number | null
    average: number | null
    orphan_id: string
    academic_level_id: number | null
    speciality: string
    university?: string
    note?: string
}
