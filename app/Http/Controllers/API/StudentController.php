<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
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
        $user = $request->currentUser()->info;
        $user->birthday = $request->birthday;
        $user->civil_status = $request->civil_status;
        $user->birthplace = $request->birthplace;
        $user->religion = $request->religion;
        $user->gender = $request->gender;
        $user->nationality = $request->nationality;
        $user->save();

    }
}
