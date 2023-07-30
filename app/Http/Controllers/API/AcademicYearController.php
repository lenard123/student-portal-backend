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

        return AcademicYear::create($request->only('department', 'name'));
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
