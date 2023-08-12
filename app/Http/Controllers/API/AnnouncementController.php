<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        return Announcement::all();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
        ]);

        return Announcement::create($request->only('title', 'content') + [
            'user_id' => auth('web:admin')->id()
        ]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
        ]);
        $announcement->update($request->only('title', 'content'));
        return $announcement;
    }

    public function destroy(Announcement $announcement)
    {
        return $announcement->delete();
    }
}
