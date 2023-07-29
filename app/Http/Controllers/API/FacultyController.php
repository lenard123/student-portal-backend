<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        return User::where('role', User::ROLE_FACULTY)->get();
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

        return User::create($request->only(
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
