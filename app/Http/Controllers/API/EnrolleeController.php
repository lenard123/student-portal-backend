<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Enrollee;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrolleeController extends Controller
{
    public function show(Enrollee $enrollee)
    {
        $enrollee->load('student', 'gradeLevel', 'academicYear');
        $enrollee->gradeLevel->subjects;
        $enrollee->gradeLevel->fees;
        $enrollee->gradeLevel->sections;
        return $enrollee;
    }

    public function index(Request $request)
    {
        return $request->currentUser()->registration->load('gradeLevel:id,name');
    }

    /**
     * Registration status must be pending
     * Students must not be enrolled yet
     * Academic year status must be enrollment
     * Section_id must be under the grade level
     */
    public function enroll(Enrollee $enrollee, Request $request)
    {
        $this->validate($request, [
            'section_id' => 'required|exists:sections,id'
        ]);

        if ($enrollee->status != Enrollee::STATUS_PENDING) {
            abort(400, "Your registration status is not set to pending");
        }

        if ($enrollee->student->currentRegistration()->exists()) {
            abort(400, "This student is currently enrolled");
        }

        if ($enrollee->gradeLevel->academicYear()?->status != AcademicYear::STATUS_ENROLLMENT) {
            abort(400, "You can't enroll in this academic year at the moment");
        }

        $section = Section::find($request->section_id);

        if ($section->grade_level_id !== $enrollee->grade_level_id) {
            abort(400, "Invalid Section ID");
        }

        $enrollee->update([
            'status' => Enrollee::STATUS_ENROLLED,
            'section_id' => $request->section_id
        ]);

        $enrollee->load('student', 'gradeLevel', 'academicYear');
        $enrollee->gradeLevel->subjects;
        $enrollee->gradeLevel->fees;
        $enrollee->gradeLevel->sections;

        return $enrollee;
    }
}
