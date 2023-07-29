<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    public function index()
    {
        return GradeLevel::all();
    }

    public function show(GradeLevel $level)
    {
        $level->subjects;
        $level->fees;
        return $level;
    }

    public function addSubject(Request $request, GradeLevel $level)
    {
        $this->validate($request, [
            'subject_id' => 'required|exists:subjects,id'
        ]);

        $level->subjects()->attach($request->subject_id, [
            'academic_year_id' => $level->academicYear()->id
        ]);

        return $level->subjects()->get();
    }

    public function addFee(Request $request, GradeLevel $level)
    {
        $this->validate($request, [
            'fee' => 'required',
            'amount' => 'required|numeric',
        ]);

        $level->fees()->create(
            $request->only('fee', 'amount') + [
                'academic_year_id' => $level->academicYear()->id
            ]
        );

        return $level->fees()->get();
    }
}
