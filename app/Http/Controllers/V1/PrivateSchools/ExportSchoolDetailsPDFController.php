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
        return saveToPDF('private-school', 'private_school',
            fn () => $school->load(['subjects:subject_id,academic_level_id,private_school_id', 'subjects.subject', 'subjects.academicLevel:id,level', 'eventsWithOrphans']), attribute: $school->name, landscape: false);
    }
}
