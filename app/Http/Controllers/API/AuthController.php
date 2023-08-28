<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function currentUser($role)
    {
        $auth = Auth::guard("web:$role");

        if (!$auth->check()) {
            abort(401, "You need to login first");
        }

        $user = $auth->user();

        if ($user->role == User::ROLE_STUDENT) {
            $user->info;
        }

        return $user;
    }

    public function currentStudent()
    {
        return Auth::guard('web:student')->user();
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
        ]);

        $auth = Auth::guard("web:$request->role");
        $credentials = $request->only('email', 'password', 'role');
        if (!$auth->attempt($credentials)) {
            abort(422, "Sorry, wrong email or password.");
        }

        return $auth->user();
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'role' => 'required'
        ]);

        Auth::guard("web:$request->role")->logout();
        return response()->noContent();
    }

    public function logoutStudent()
    {
        Auth::guard('web:student')->logout();
        return response()->noContent();
    }
}
