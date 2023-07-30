<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    public function show(Section $section)
    {
        $section->gradeLevel->subjects->load('faculties');
        $section->load('schedules');
        return $section;
    }

    public function addSubject(Section $section, Request $request)
    {
        $this->validate($request, [
            'subject_id' => 'required|exists:subjects,id',
            'faculty_id' => 'required|exists:users,id',
            'schedules' => 'required|array|size:7'
        ]);

        return Schedule::updateOrCreate(
            $request->only('subject_id') + ['section_id' => $section->id],
            $request->only('faculty_id', 'schedules')
        );
    }
}
