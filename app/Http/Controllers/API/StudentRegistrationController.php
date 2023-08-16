<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Enrollee;
use App\Models\GradeLevel;
use App\Models\Student;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentRegistrationController extends Controller
{
    public function sendOtp(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'contact_number' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        return response()->noContent();
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'contact_number' => 'required',
            'password' => 'required|min:8|confirmed',
            'department' => 'required'
        ]);

        return Student::create($request->only('firstname', 'lastname', 'email', 'password', 'department'));
    }

    public function downloadRegistrationForm()
    {
        return Pdf::loadView('pdf.registration-form')->stream();
    }

    /**
     * Student must not have any pending enrollment
     * Student must not be enrolled
     * Department enrollment status must be started
     * GradeLevel department must be same to the student Department
     */
    public function enroll(Request $request)
    {
        $this->validate($request, [
            'grade_level_id' => 'required|exists:grade_levels,id'
        ]);

        $user = Auth::guard('web:student')->user();

        if ($user->hasPendingRegistration()) {
            abort(400, "You still have a pending registration");
        }

        if ($user->currentRegistration()->exists()) {
            abort(400, "This student is currently enrolled");
        }

        $activeAcademicYear = AcademicYear::getActiveAcademicYear($user->department);

        if ($activeAcademicYear?->status !== AcademicYear::STATUS_ENROLLMENT) {
            abort(400, "Enrollment has not yet started");
        }

        $gradeLevel = GradeLevel::find($request->grade_level_id);

        if ($gradeLevel->department != $user->department) {
            abort(400, "You are not allowed to enroll in this grade level");
        }

        return Enrollee::create([
            'student_id' => $user->id,
            'academic_year_id' => AcademicYear::getActiveAcademicYear($user->department)->id,
            'grade_level_id' => $request->grade_level_id,
            'status' => Enrollee::STATUS_PENDING
        ]);
    }
}
