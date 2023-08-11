<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Enrollee;
use Illuminate\Http\Request;

class EnrolleeController extends Controller
{
    public function show(Enrollee $enrollee)
    {
        $enrollee->load('student', 'gradeLevel', 'academicYear');
        $enrollee->gradeLevel->subjects;
        $enrollee->gradeLevel->fees;
        return $enrollee;
    }
}
