<?php

namespace Database\Seeders;

use App\Models\AcademicLevel;
use Illuminate\Database\Seeder;

class AcademicLevelSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'id' => 1,
                'level' => 'تحضيري',
                'phase' => 'الطور الابتدائي',
                'phase_key' => 'elementary_school',
                'subject_ids' => json_encode([11, 27, 3, 5, 6, 4, 7, 9]),
            ],
            [
                'id' => 2,
                'level' => 'الأولى ابتدائي',
                'phase' => 'الطور الابتدائي',
                'phase_key' => 'elementary_school',
                'subject_ids' => json_encode([11, 27, 13, 12, 3, 5, 26, 6, 4, 8, 9, 7]),
            ],
            [
                'id' => 3,
                'level' => 'الثانية ابتدائي',
                'phase' => 'الطور الابتدائي',
                'phase_key' => 'elementary_school',
                'subject_ids' => json_encode([11, 27, 13, 12, 3, 5, 26, 6, 4, 8, 7]),
            ],
            [
                'id' => 4,
                'level' => 'الثالثة ابتدائي',
                'phase' => 'الطور الابتدائي',
                'phase_key' => 'elementary_school',
                'subject_ids' => json_encode([11, 27, 13, 12, 2, 3, 5, 26, 6, 4, 8, 7]),
            ],
            [
                'id' => 5,
                'level' => 'الرابعة ابتدائي',
                'phase' => 'الطور الابتدائي',
                'phase_key' => 'elementary_school',
                'subject_ids' => json_encode([11, 27, 13, 12, 2, 3, 5, 26, 6, 4, 8, 7]),
            ],
            [
                'id' => 6,
                'level' => 'الخامسة ابتدائي',
                'phase' => 'الطور الابتدائي',
                'phase_key' => 'elementary_school',
                'subject_ids' => json_encode([11, 27, 13, 12, 2, 3, 5, 26, 6, 7, 4, 8]),
            ],
            [
                'id' => 7,
                'level' => 'الأولى المتوسط',
                'phase' => 'الطور المتوسط',
                'phase_key' => 'middle_school',
                'subject_ids' => json_encode([11, 27, 13, 12, 2, 1, 15, 3, 5, 26, 28, 4, 8, 29]),
            ],
            [
                'id' => 8,
                'level' => 'الثانية المتوسط',
                'phase' => 'الطور المتوسط',
                'phase_key' => 'middle_school',
                'subject_ids' => json_encode([11, 27, 13, 12, 2, 1, 15, 3, 5, 26, 28, 4, 8, 29]),
            ],
            [
                'id' => 9,
                'level' => 'الثالثة المتوسط',
                'phase' => 'الطور المتوسط',
                'phase_key' => 'middle_school',
                'subject_ids' => json_encode([11, 27, 13, 12, 2, 1, 15, 3, 5, 26, 28, 4, 8, 29]),
            ],
            [
                'id' => 10,
                'level' => 'الرابعة المتوسط',
                'phase' => 'الطور المتوسط',
                'phase_key' => 'middle_school',
                'subject_ids' => json_encode([11, 27, 13, 12, 2, 1, 15, 3, 5, 26, 28, 4, 8, 29]),
            ],
            [
                'id' => 11,
                'level' => 'الأولى ثانوي آداب',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 1, 15, 31, 2, 13, 12, 28, 29, 26]),
            ],
            [
                'id' => 12,
                'level' => 'الأولى ثانوي علوم',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 1, 15, 31, 2, 13, 12, 28, 32, 29, 26]),
            ],
            [
                'id' => 13,
                'level' => 'الثانية ثانوي رياضيات',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 15, 1, 31, 2, 13, 12, 29, 26]),
            ],
            [
                'id' => 14,
                'level' => 'الثانية ثانوي تقني رياضي (هندسة مدنية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 20, 1, 31, 2, 13, 12, 29, 26]),
            ],
            [
                'id' => 15,
                'level' => 'الثانية ثانوي تقني رياضي (هندسة الطرائق)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 23, 1, 31, 2, 13, 12, 29, 26]),
            ],
            [
                'id' => 16,
                'level' => 'الثانية ثانوي تقني رياضي (هندسة ميكانيكية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 22, 1, 31, 2, 13, 12, 29, 26]),
            ],
            [
                'id' => 17,
                'level' => 'الثانية ثانوي تقني رياضي (هندسة كهربائية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 21, 1, 31, 2, 13, 12, 29, 26]),
            ],
            [
                'id' => 18,
                'level' => 'الثانية ثانوي علوم تجريبية',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 15, 1, 31, 2, 13, 12, 29, 26]),
            ],
            [
                'id' => 19,
                'level' => 'الثانية ثانوي تسيير و اقتصاد',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 18, 19, 17, 31, 2, 13, 12, 29, 26]),
            ],
            [
                'id' => 20,
                'level' => 'الثانية ثانوي أدب و فلسفة',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 16, 2, 31, 13, 12, 1, 15, 29, 26]),
            ],
            [
                'id' => 21,
                'level' => 'الثانية ثانوي لغات أجنبية (اللغة الألمانية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 12, 13, 24, 31, 2, 29, 26]),
            ],
            [
                'id' => 22,
                'level' => 'الثانية ثانوي لغات أجنبية (اللغة الإسبانية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 12, 13, 25, 31, 2, 29, 26]),
            ],
            [
                'id' => 23,
                'level' => 'الثانية ثانوي لغات أجنبية (اللغة الإيطالية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 12, 13, 14, 31, 2, 29, 26]),
            ],
            [
                'id' => 24,
                'level' => 'الثالثة ثانوي رياضيات',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 15, 1, 31, 2, 13, 12, 16, 29, 26]),
            ],
            [
                'id' => 25,
                'level' => 'الثالثة ثانوي تقني رياضي (هندسة مدنية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 20, 1, 31, 2, 13, 12, 16, 29, 26]),
            ],
            [
                'id' => 26,
                'level' => 'الثالثة ثانوي تقني رياضي (هندسة الطرائق)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 23, 1, 31, 2, 13, 12, 16, 29, 26]),
            ],
            [
                'id' => 27,
                'level' => 'الثالثة ثانوي تقني رياضي (هندسة ميكانيكية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 22, 1, 31, 2, 13, 12, 16, 29, 26]),
            ],
            [
                'id' => 28,
                'level' => 'الثالثة ثانوي تقني رياضي (هندسة كهربائية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 21, 1, 31, 2, 13, 12, 16, 29, 26]),
            ],
            [
                'id' => 29,
                'level' => 'الثالثة ثانوي علوم تجريبية',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 15, 1, 31, 2, 13, 12, 16, 29, 26]),
            ],
            [
                'id' => 30,
                'level' => 'الثالثة ثانوي تسيير و إقتصاد',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 18, 19, 17, 31, 2, 13, 12, 16, 29, 26]),
            ],
            [
                'id' => 31,
                'level' => 'الثالثة ثانوي أدب و فلسفة',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 16, 2, 31, 13, 12, 29, 26]),
            ],
            [
                'id' => 32,
                'level' => 'الثالثة ثانوي لغات أجنبية (اللغة الألمانية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 12, 13, 24, 31, 2, 16, 29, 26]),
            ],
            [
                'id' => 33,
                'level' => 'الثالثة ثانوي لغات أجنبية (اللغة الإسبانية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 12, 13, 24, 31, 2, 16, 29, 26]),
            ],
            [
                'id' => 34,
                'level' => 'الثالثة ثانوي لغات أجنبية (اللغة الإيطالية)',
                'phase' => 'الطور الثانوي',
                'phase_key' => 'high_school',
                'subject_ids' => json_encode([30, 11, 12, 13, 24, 31, 2, 16, 29, 26]),
            ],
            [
                'id' => 35,
                'level' => 'الأولى ليسانس',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,

            ],
            [
                'id' => 36,
                'level' => 'الثانية ليسانس',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,
            ],
            [
                'id' => 37,
                'level' => 'الثالثة ليسانس',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,
            ],
            [
                'id' => 38,
                'level' => 'الأولى ماستر',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,
            ],
            [
                'id' => 39,
                'level' => 'الثانية ماستر',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,
            ],
            [
                'id' => 40,
                'level' => 'الأولى دكتوراه',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,
            ],
            [
                'id' => 41,
                'level' => 'الثانية دكتوراه',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,
            ],
            [
                'id' => 42,
                'level' => 'الثالثة دكتوراه',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,
            ],
            [
                'id' => 43,
                'level' => 'الرابعة دكتوراه',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,
            ],
            [
                'id' => 44,
                'level' => 'الخامسة دكتوراه',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,
            ],
            [
                'id' => 45,
                'level' => 'متخرج',
                'phase' => 'الطور الجامعي',
                'phase_key' => 'university',
                'subject_ids' => null,
            ],
            [
                'id' => 46,
                'level' => 'السنة الأولى',
                'phase' => 'الشبه طبي',
                'phase_key' => 'paramedical',
                'subject_ids' => null,
            ],
            [
                'id' => 47,
                'level' => 'السنة الثانية',
                'phase' => 'الشبه طبي',
                'phase_key' => 'paramedical',
                'subject_ids' => null,
            ],
            [
                'id' => 48,
                'level' => 'السنة الثالثة',
                'phase' => 'الشبه طبي',
                'phase_key' => 'paramedical',
                'subject_ids' => null,
            ],
            [
                'id' => 49,
                'level' => 'السنة الرابعة',
                'phase' => 'الشبه طبي',
                'phase_key' => 'paramedical',
                'subject_ids' => null,
            ],
            [
                'id' => 50,
                'level' => 'السنة الخامسة',
                'phase' => 'الشبه طبي',
                'phase_key' => 'paramedical',
                'subject_ids' => null,
            ],
            [
                'id' => 51,
                'level' => 'مفصول',
                'phase' => 'اخر',
                'phase_key' => 'other',
                'subject_ids' => null,
            ],
            [
                'id' => 52,
                'level' => 'امي',
                'phase' => 'اخر',
                'phase_key' => 'other',
                'subject_ids' => null,
            ],
            [
                'id' => 53,
                'level' => 'السنة الأولى',
                'phase' => 'التكوين المهني',
                'phase_key' => 'vocational_training',
                'subject_ids' => null,
            ],
            [
                'id' => 54,
                'level' => 'السنة الثانية',
                'phase' => 'التكوين المهني',
                'phase_key' => 'vocational_training',
                'subject_ids' => null,
            ],
            [
                'id' => 55,
                'level' => 'السنة الثالثة',
                'phase' => 'التكوين المهني',
                'phase_key' => 'vocational_training',
                'subject_ids' => null,
            ],
        ];

        AcademicLevel::insert($rows);
    }
}