<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        return Subject::with('gradeLevel')->orderBy('grade_level_id')->get();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'grade_level_id' => 'required|exists:grade_levels,id',
            'name' => 'required'
        ]);

        return Subject::create($request->only('grade_level_id', 'name'))->load('gradeLevel');
    }
}
