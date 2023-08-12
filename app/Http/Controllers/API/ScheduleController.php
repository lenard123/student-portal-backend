<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function show(Schedule $schedule)
    {
        return $schedule->load('faculty', 'section.gradeLevel', 'subject');
    }
}
