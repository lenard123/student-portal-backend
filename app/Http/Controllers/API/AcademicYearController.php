<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        return AcademicYear::all();
    }

    public function sections(AcademicYear $school_year)
    {
        return $school_year->sections()->with('gradeLevel')->orderBy('grade_level_id')->get();
    }

    public function createSection(AcademicYear $school_year, Request $request)
    {
        $this->validate($request, [
            'grade_level_id' => 'required|exists:grade_levels,id',
            'name' => 'required'
        ]);

        $section = $school_year->sections()->create($request->only('grade_level_id', 'name'));
        return $section->load('gradeLevel');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'department' => 'required',
            'name' => 'required'
        ]);

        $active = AcademicYear::getActiveAcademicYear($request->department);

        if ($active !== null) {
            abort(400, "You can't create a school year yet in this department");
        }

        return AcademicYear::create($request->only('department', 'name'));
    }

    public function startEnrollment(AcademicYear $school_year)
    {
        if ($school_year->status != AcademicYear::STATUS_PREPARATION) {
            abort(400, "This is not a pending academic year.");
        }

        foreach ($school_year->gradeLevels as $gradeLevel) {
            if (!$gradeLevel->sections($school_year->id)->exists()) {
                abort(400, "There is still no section in {$gradeLevel->name}");
            }
        }

        $school_year->update([
            'status' => AcademicYear::STATUS_ENROLLMENT
        ]);

        return $school_year;
    }

    public function enrollees(AcademicYear $school_year)
    {
        return $school_year->enrollees->load('student', 'gradeLevel', 'section');
    }

    public function activeAcademicYear()
    {
        return [
            User::DEPARTMENT_PRESCHOOL => AcademicYear::getActiveAcademicYear(User::DEPARTMENT_PRESCHOOL),
            User::DEPARTMENT_ELEMENTARY => AcademicYear::getActiveAcademicYear(User::DEPARTMENT_ELEMENTARY),
            User::DEPARTMENT_JUNIOR_HIGH => AcademicYear::getActiveAcademicYear(User::DEPARTMENT_JUNIOR_HIGH),
            User::DEPARTMENT_SENIOR_HIGH => AcademicYear::getActiveAcademicYear(User::DEPARTMENT_SENIOR_HIGH),
        ];
    }
}
