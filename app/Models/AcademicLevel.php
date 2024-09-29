<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Sushi\Sushi;

/**
 *
 *
 * @property int $id
 * @property string|null $level
 * @property string|null $phase
 * @method static Builder|AcademicLevel newModelQuery()
 * @method static Builder|AcademicLevel newQuery()
 * @method static Builder|AcademicLevel query()
 * @method static Builder|AcademicLevel whereId($value)
 * @method static Builder|AcademicLevel whereLevel($value)
 * @method static Builder|AcademicLevel wherePhase($value)
 * @mixin Eloquent
 */
class AcademicLevel extends Model
{
    use Searchable, Sushi;

    protected array $rows = [
        [
            'id' => 1,
            'level' => 'الأولى ابتدائي',
            'phase' => 'الطور الابتدائي',
        ],
        [
            'id' => 2,
            'level' => 'الثانية ابتدائي',
            'phase' => 'الطور الابتدائي',
        ],
        [
            'id' => 3,
            'level' => 'الثالثة ابتدائي',
            'phase' => 'الطور الابتدائي',
        ],
        [
            'id' => 4,
            'level' => 'الرابعة ابتدائي',
            'phase' => 'الطور الابتدائي',
        ],
        [
            'id' => 5,
            'level' => 'الخامسة ابتدائي',
            'phase' => 'الطور الابتدائي',
        ],
        [
            'id' => 6,
            'level' => 'الأولى المتوسط',
            'phase' => 'الطور المتوسط',
        ],
        [
            'id' => 7,
            'level' => 'الثانية المتوسط',
            'phase' => 'الطور المتوسط',
        ],
        [
            'id' => 8,
            'level' => 'الثالثة المتوسط',
            'phase' => 'الطور المتوسط',
        ],
        [
            'id' => 9,
            'level' => 'الرابعة المتوسط',
            'phase' => 'الطور المتوسط',
        ],
        [
            'id' => 10,
            'level' => 'الأولى ثانوي آداب',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 11,
            'level' => 'الأولى ثانوي علوم',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 12,
            'level' => 'الثانية ثانوي رياضيات',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 13,
            'level' => 'الثانية ثانوي تقني رياضي',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 14,
            'level' => 'الثانية ثانوي علوم تجريبية',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 15,
            'level' => 'الثانية ثانوي تسيير و اقتصاد',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 16,
            'level' => 'الثانية ثانوي أدب و فلسفة',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 17,
            'level' => 'الثانية ثانوي لغات أجنبية',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 18,
            'level' => 'الثالثة ثانوي رياضيات',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 19,
            'level' => 'الثالثة ثانوي تقني رياضي',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 20,
            'level' => 'الثالثة ثانوي علوم تجريبية',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 21,
            'level' => 'الثالثة ثانوي ت و إقتصاد',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 22,
            'level' => 'الثالثة ثانوي أدب و فلسفة',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 23,
            'level' => 'الثالثة ثانوي لغات أجنبية',
            'phase' => 'الطور الثانوي',
        ],
        [
            'id' => 24,
            'level' => 'الأولى ليسانس',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 25,
            'level' => 'الثانية ليسانس',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 26,
            'level' => 'الثالثة ليسانس',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 27,
            'level' => 'الأولى ماستر',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 28,
            'level' => 'الثانية ماستر',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 29,
            'level' => 'الأولى دكتوراه',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 30,
            'level' => 'الثانية دكتوراه',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 31,
            'level' => 'الثالثة دكتوراه',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 32,
            'level' => 'الرابعة دكتوراه',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 33,
            'level' => 'الخامسة دكتوراه',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 34,
            'level' => 'متخرج',
            'phase' => 'الطور الجامعي',
        ],
        [
            'id' => 35,
            'level' => 'تحضيري',
            'phase' => 'الطور الابتدائي',
        ],
        [
            'id' => 36,
            'level' => 'السنة الأولى',
            'phase' => 'الشبه طبي',
        ],
        [
            'id' => 37,
            'level' => 'السنة الثانية',
            'phase' => 'الشبه طبي',
        ],
        [
            'id' => 38,
            'level' => 'السنة الثالثة',
            'phase' => 'الشبه طبي',
        ],
        [
            'id' => 39,
            'level' => 'السنة الرابعة',
            'phase' => 'الشبه طبي',
        ],
        [
            'id' => 40,
            'level' => 'السنة الخامسة',
            'phase' => 'الشبه طبي',
        ],
        [
            'id' => 41,
            'level' => 'مفصول',
            'phase' => 'اخر',
        ],
        [
            'id' => 42,
            'level' => 'امي',
            'phase' => 'اخر',
        ],
        [
            'id' => 43,
            'level' => 'السنة الأولى',
            'phase' => 'التكوين المهني',
        ],
        [
            'id' => 44,
            'level' => 'السنة الثانية',
            'phase' => 'التكوين المهني',
        ],
        [
            'id' => 45,
            'level' => 'السنة الثالثة',
            'phase' => 'التكوين المهني',
        ],
    ];

    public function toSearchableArray(): array
    {
        return $this->toArray();
    }
}
