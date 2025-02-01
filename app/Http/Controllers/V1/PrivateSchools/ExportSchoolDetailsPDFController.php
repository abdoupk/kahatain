<?php

namespace App\Http\Controllers\V1\PrivateSchools;

use App\Http\Controllers\Controller;
use App\Models\PrivateSchool;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Throwable;

class ExportSchoolDetailsPDFController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:print_schools'];
    }

    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(PrivateSchool $school)
    {
        return saveToPDF('private-school', 'school',
            fn () => $school->load(['subjects.academicLevel', 'lessons'])->loadCount(['lessons', 'subjects']), landscape: false);
    }
}
