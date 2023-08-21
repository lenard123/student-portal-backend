<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Media;
use App\Models\Post;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function lessons(Schedule $schedule)
    {
        return $schedule->lessons;
    }

    public function assignments(Schedule $schedule)
    {
        return $schedule->assignments;
    }

    public function createPost(Schedule $schedule, Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);

        $request->merge(['author_id' => $request->currentUser()->id]);

        return $schedule->posts()->create($request->only('description', 'author_id'));
    }

    public function createAssignment(Schedule $schedule, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'deadline' => 'nullable|date',
            'files' => 'array',
            'files.*' => 'file'
        ]);

        return DB::transaction(function () use ($schedule, $request) {
            $assignment = $schedule->assignments()->create(
                $request->merge(['author_id' => $request->currentUser()->id])
                    ->only('title', 'description', 'deadline', 'author_id')
            );

            foreach ($request->file('files') ?? [] as $file) {
                Media::upload($assignment, $file, "assignments", "local");
            }

            return $assignment;
        });
    }

    public function createLesson(Schedule $schedule, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'files' => 'array',
            'files.*' => 'file'
        ]);

        return DB::transaction(function () use ($schedule, $request) {


            $lesson = $schedule->lessons()->create(
                $request->merge(['author_id' => $request->currentUser()->id])
                    ->only('title', 'description', 'author_id')
            );

            foreach ($request->file('files') ?? [] as $file) {
                Media::upload($lesson, $file, "lessons", "local");
            }


            return $lesson;
        });
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
