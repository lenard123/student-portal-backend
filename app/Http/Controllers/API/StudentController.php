<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Enrollee;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::whereHas('currentRegistration', function ($query) {
            $query->where('status', Enrollee::STATUS_ENROLLED)
                ->orWhereHas('academicYear', function ($subquery) {
                    $subquery->whereIn('status', [AcademicYear::STATUS_STARTED, AcademicYear::STATUS_ENROLLMENT]);
                });
        })->get();
    
        return $students;
    }
    
    public function subjects()
    {
        $user = Auth::guard('web:student')->user();

        if (!$user->currentRegistration()->exists())
            return [];

        return $user->currentRegistration->schedules->load('subject', 'faculty');
    }

    public function updateInfo(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        $user = $request->currentUser();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->save();
    }

    public function updateOtherInfo(Request $request)
    {
        try {
            $user = $request->currentUser()->info;
            $user->birthday = $request->birthday;
            $user->civil_status = $request->civil_status;
            $user->birthplace = $request->birthplace;
            $user->religion = $request->religion;
            $user->gender = $request->gender;
            $user->nationality = $request->nationality;
            $user->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
