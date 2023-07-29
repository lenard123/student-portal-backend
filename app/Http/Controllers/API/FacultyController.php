<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        return Faculty::all();
    }

    public function show(Faculty $faculty)
    {
        return $faculty->load('subjects.gradeLevel');
    }

    public function addSubject(Faculty $faculty, Request $request)
    {
        $this->validate($request, [
            'subject_id' => 'required|exists:subjects,id'
        ]);

        $faculty->subjects()->syncWithoutDetaching([$request->subject_id]);

        return $faculty->subjects()->get()->load('gradeLevel');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'department' => 'required'
        ]);

        return Faculty::create($request->only(
            'firstname',
            'middlename',
            'lastname',
            'email',
            'password',
            'department'
        )+ [
            'role' => User::ROLE_FACULTY
        ]);
    }
}
