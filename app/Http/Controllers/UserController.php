<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image'
        ]);

        $user = $request->currentUser();
        $user->avatar = $request->file('avatar')->store('avatars', 'public');
        $user->save();

        return $user;
    }
}
