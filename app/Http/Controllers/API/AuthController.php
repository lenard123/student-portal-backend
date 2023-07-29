<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function currentUser()
    {
        return auth()->user();
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            abort(422, "Sorry we can't find your email on our database.");
        }

        if ($user->role !== $request->role) {
            abort(422, "Your account is not registered on this user role");
        }

        if (!Hash::check($request->password, $user->password)) {
            abort(422, "Wrong email or password");
        }

        Auth::login($user);

        return $user;
    }

    public function logout()
    {
        Auth::logout();
        return response()->noContent();
    }
}
