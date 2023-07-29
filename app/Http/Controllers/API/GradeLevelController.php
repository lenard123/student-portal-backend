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
}
