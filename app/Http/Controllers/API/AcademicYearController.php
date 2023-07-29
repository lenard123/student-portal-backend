<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        return AcademicYear::all();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'department' => 'required',
            'name' => 'required'
        ]);

        return AcademicYear::create($request->only('department', 'name'));
    }
}
