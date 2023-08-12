<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Post;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function show(Schedule $schedule)
    {
        return $schedule->load('faculty', 'section.gradeLevel', 'subject');
    }

    public function posts(Schedule $schedule)
    {
        return $schedule->posts;
    }

    public function createPost(Schedule $schedule, Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);

        $request->merge(['author_id' => $request->currentUser()->id]);

        return $schedule->posts()->create($request->only('description', 'author_id'));
    }

    public function index(Request $request)
    {
        $user = $request->currentUser();
        if ($request->role('student')) {

            if (!$user->currentRegistration()->exists())
                return [];

            return $user->currentRegistration->schedules->load('subject', 'faculty');
        }

        if ($request->role('faculty')) {
            $academic_year = AcademicYear::getActiveAcademicYear($user->department);

            if ($academic_year == null) {
                return [];
            }

            return $user->schedules($academic_year->id)->with('subject', 'faculty')->get();
        }
    }
}
