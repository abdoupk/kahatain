<?php

namespace Database\Seeders;

use App\Models\UniversitySpeciality;
use Illuminate\Database\Seeder;

class UniversitySpecialitySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'id' => 1,
                'speciality' => 'طب الأسنان',
            ],
            [
                'id' => 2,
                'speciality' => 'الطيران',
            ],
            [
                'id' => 3,
                'speciality' => 'أشغال عمومية',
            ],
            [
                'id' => 4,
                'speciality' => 'نظافة وأمن صناعي',
            ],
            [
                'id' => 5,
                'speciality' => 'حقوق',
            ],
            [
                'id' => 6,
                'speciality' => 'تكنولوجيا',
            ],
            [
                'id' => 7,
                'speciality' => 'علوم سياسية',
            ],
            [
                'id' => 8,
                'speciality' => 'علوم البيطرة',
            ],
            [
                'id' => 9,
                'speciality' => 'العلوم الإسلامية',
            ],
            [
                'id' => 10,
                'speciality' => 'هندسة صناعية',
            ],
            [
                'id' => 11,
                'speciality' => 'هندسة الطرائق',
            ],
            [
                'id' => 12,
                'speciality' => 'علوم فلاحية',
            ],
            [
                'id' => 13,
                'speciality' => 'مناجم',
            ],
            [
                'id' => 14,
                'speciality' => 'جيومتر طوبوغراف',
            ],
            [
                'id' => 15,
                'speciality' => 'علوم التمريض',
            ],
            [
                'id' => 16,
                'speciality' => 'كهروميكانيك',
            ],
            [
                'id' => 17,
                'speciality' => 'جيولوجيا ومحيط',
            ],
            [
                'id' => 18,
                'speciality' => 'اتصالات سلكية ولا سلكية',
            ],
            [
                'id' => 19,
                'speciality' => 'الطب',
            ],
            [
                'id' => 20,
                'speciality' => 'هندسة كهربائية وإلكترونيك',
            ],
            [
                'id' => 21,
                'speciality' => 'الهندسة المعمارية والعمران',
            ],
            [
                'id' => 22,
                'speciality' => 'صناعات بتروكيميائية',
            ],
            [
                'id' => 23,
                'speciality' => 'اللغات الأجنبية',
            ],
            [
                'id' => 24,
                'speciality' => 'علوم الطبيعة والحياة',
            ],
            [
                'id' => 25,
                'speciality' => 'علوم إنسانية',
            ],
            [
                'id' => 26,
                'speciality' => 'علوم اقتصادية التسيير وع.تجارية',
            ],
            [
                'id' => 27,
                'speciality' => 'علوم وتقنيات النشاطات البدنية والرياضية',
            ],
            [
                'id' => 28,
                'speciality' => 'تسيير التقنيات الحضرية',
            ],
            [
                'id' => 29,
                'speciality' => 'الهندسة الميكانيكية',
            ],
            [
                'id' => 30,
                'speciality' => 'تغذية وتكنولوجيا زراعية غذائية',
            ],
            [
                'id' => 31,
                'speciality' => 'لغة وثقافة أمازيغية',
            ],
            [
                'id' => 32,
                'speciality' => 'هندسة المبلورات',
            ],
            [
                'id' => 33,
                'speciality' => 'هندسة المياه',
            ],
            [
                'id' => 34,
                'speciality' => 'كهروتقني وطاقات متجددة',
            ],
            [
                'id' => 35,
                'speciality' => 'تسيير المؤسسات والإدارات',
            ],
            [
                'id' => 36,
                'speciality' => 'بيولوجيا وتكنولوجيا تربية النحل',
            ],
            [
                'id' => 37,
                'speciality' => 'ميدان تكوين فنون',
            ],
            [
                'id' => 38,
                'speciality' => 'الصيدلة',
            ],
            [
                'id' => 39,
                'speciality' => 'محروقات وكيمياء',
            ],
            [
                'id' => 40,
                'speciality' => 'رياضيات وإعلام آلي',
            ],
            [
                'id' => 41,
                'speciality' => 'تخصص ترجمة',
            ],
            [
                'id' => 42,
                'speciality' => 'لغة وأدب عربي',
            ],
            [
                'id' => 43,
                'speciality' => 'علوم المادة',
            ],
            [
                'id' => 44,
                'speciality' => 'علوم اجتماعية',
            ],
            [
                'id' => 45,
                'speciality' => 'علوم الأرض والكون',
            ],
            [
                'id' => 46,
                'speciality' => 'الهندسة البيوطبية',
            ],
            [
                'id' => 47,
                'speciality' => 'بصريات وميكانيك الضبط',
            ],
            [
                'id' => 48,
                'speciality' => 'الهندسة المدنية',
            ],
            [
                'id' => 49,
                'speciality' => 'الهندسة البحرية',
            ],
            [
                'id' => 50,
                'speciality' => 'تعدين',
            ],
            [
                'id' => 51,
                'speciality' => 'علوم الغابات',
            ],
            [
                'id' => 52,
                'speciality' => 'علوم البيئة والمحيط',
            ],
            [
                'id' => 53,
                'speciality' => 'ري',
            ],
            [
                'id' => 54,
                'speciality' => 'قيادة عملياتية للمشاريع',
            ],
            [
                'id' => 55,
                'speciality' => 'علم النفس العيادي',
            ],
            [
                'id' => 56,
                'speciality' => 'تغليف وجودة',
            ],
        ];

        UniversitySpeciality::insert($rows);
    }
}
