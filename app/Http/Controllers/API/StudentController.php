<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
}
