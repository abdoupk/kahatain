<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

/**
 * @property int $id
 * @property string|null $en_name
 * @property string|null $ar_name
 * @property string|null $fr_name
 *
 * @method static Builder|Subject newModelQuery()
 * @method static Builder|Subject newQuery()
 * @method static Builder|Subject query()
 * @method static Builder|Subject whereArName($value)
 * @method static Builder|Subject whereEnName($value)
 * @method static Builder|Subject whereFrName($value)
 * @method static Builder|Subject whereId($value)
 *
 * @mixin Eloquent
 */
class Subject extends Model
{
    use Sushi;

    protected array $rows = [
        [
            'id' => 1,
            'en_name' => 'physic',
            'ar_name' => 'العلوم الفيزيائية',
            'fr_name' => 'physique',
        ],
        [
            'id' => 2,
            'en_name' => 'History and Geography',
            'ar_name' => 'التاريخ والجغرافيا',
            'fr_name' => 'histoire et geography',
        ],
        [
            'id' => 3,
            'en_name' => 'Islamic education',
            'ar_name' => 'التربية الإسلامية',
            'fr_name' => 'education islamique',
        ],
        [
            'id' => 4,
            'en_name' => 'Art education',
            'ar_name' => 'التربية الفنية',
            'fr_name' => 'education artistique',
        ],
        [
            'id' => 5,
            'ar_name' => 'التربية المدنية',
            'fr_name' => 'education urbaine',
            'en_name' => 'urban education',
        ],
        [
            'id' => 6,
            'ar_name' => 'التربية العلمية و التكنولوجية',
            'fr_name' => 'education scientifique et technologique',
            'en_name' => 'scientific and technological education',
        ],
        [
            'id' => 7,
            'ar_name' => 'الانشطة',
            'fr_name' => 'activites',
            'en_name' => 'activities',
        ],
        [
            'id' => 8,
            'ar_name' => 'التربية الموسيقية',
            'fr_name' => 'education musicale',
            'en_name' => 'music education',
        ],
        [
            'id' => 9,
            'ar_name' => 'تعلم الكتابة',
            'fr_name' => 'Apprendre à écrire',
            'en_name' => 'learning to write',
        ],
        [
            'id' => 10,
            'ar_name' => 'التكنولوجيا',
            'fr_name' => 'technologie',
            'en_name' => 'technology',
        ],
        [
            'id' => 11,
            'en_name' => 'Math',
            'ar_name' => 'الرياضيات',
            'fr_name' => 'Math',
        ],
        [
            'id' => 12,
            'en_name' => 'english',
            'ar_name' => 'اللغة الانجليزية',
            'fr_name' => 'anglais',
        ],
        [
            'id' => 13,
            'ar_name' => 'اللغة الفرنسية',
            'fr_name' => 'francais',
            'en_name' => 'french',
        ],
        [
            'id' => 14,
            'ar_name' => 'اللغة الايطالية',
            'fr_name' => 'italien',
            'en_name' => 'italian',
        ],
        [
            'id' => 15,
            'ar_name' => 'علوم الطبيعة و الحياة',
            'fr_name' => 'sciences naturelles',
            'en_name' => 'natural science',
        ],
        [
            'id' => 16,
            'ar_name' => 'الفلسفة',
            'fr_name' => 'philosophie',
            'en_name' => 'philosophy',
        ],
        [
            'id' => 17,
            'ar_name' => 'القانون',
            'fr_name' => 'loi',
            'en_name' => 'law',
        ],
        [
            'id' => 18,
            'ar_name' => 'التسيير المحاسبي والمالي',
            'fr_name' => 'Comptabilité et finance',
            'en_name' => 'accounting and finance',
        ],
        [
            'id' => 19,
            'ar_name' => 'الاقتصاد والمناجمنت',
            'fr_name' => 'Économie et commerce',
            'en_name' => 'economy and commerce',
        ],
        [
            'id' => 20,
            'ar_name' => 'الهندسة المدنية',
            'fr_name' => 'Génie civil',
            'en_name' => 'Civil Engineering',
        ],
        [
            'id' => 21,
            'ar_name' => 'الهندسة الكهربائية',
            'fr_name' => 'génie électrique',
            'en_name' => 'electric engineering',
        ],
        [
            'id' => 22,
            'ar_name' => 'الهندسة الميكانيكية',
            'fr_name' => 'génie mécanique',
            'en_name' => 'mechanical engineering',
        ],
        [
            'id' => 23,
            'ar_name' => 'هندسة الطرائق',
            'fr_name' => 'Génie des procédés',
            'en_name' => 'Process Engineering',
        ],
        [
            'id' => 24,
            'ar_name' => 'اللغة الالمانية',
            'fr_name' => 'Langue allemande',
            'en_name' => 'German Language',
        ],
        [
            'id' => 25,
            'ar_name' => 'اللغة الاسبانية',
            'fr_name' => 'Espagnol',
            'en_name' => 'Spanish language',
        ],
        [
            'id' => 26,
            'ar_name' => 'اللغة الامازيغية',
            'fr_name' => 'Langue tamazight',
            'en_name' => 'Tamazight language',
        ],
        [
            'id' => 27,
            'ar_name' => 'اللغة العربية',
            'fr_name' => 'Langue arabe',
            'en_name' => 'Arabic language',
        ],
        [
            'id' => 28,
            'ar_name' => 'الاعلام الالي',
            'fr_name' => 'Informatique',
            'en_name' => 'Computer Science',
        ],
    ];

    public function getName(): string
    {
        return $this[app()->getLocale().'_name'];
    }
}
