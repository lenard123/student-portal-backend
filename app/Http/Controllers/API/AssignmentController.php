<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Media;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function show(Assignment $assignment, Request $request)
    {
        $user = $request->currentUser();

        if ($user->role == User::ROLE_STUDENT)
            $assignment->setStudent($user);

        return $assignment
            ->load('files', 'submissions');
    }
    public function attachFile(Assignment $assignment, Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file'
        ]);

        $student = $request->currentUser();
        $assignment->setStudent($student);

        $submission = AssignmentSubmission::firstOrCreate(
            ['student_id' => $student->id, 'assignment_id' => $assignment->id],
            ['status' => AssignmentSubmission::STATUS_PENDING]
        );

        Media::upload($submission, $request->file('file'), 'assignments', 'local');

        return $assignment->load('files', 'submissions');
    }

    public function submitAssignment(Assignment $assignment, Request $request)
    {
        $student = $request->currentUser();
        $submission = AssignmentSubmission::firstOrCreate(
            ['student_id' => $student->id, 'assignment_id' => $assignment->id],
            ['status' => AssignmentSubmission::STATUS_PENDING]
        );

        if ($submission->status != AssignmentSubmission::STATUS_PENDING) {
            abort(400, 'This assignment is not pending');
        }

        if (!$submission->files()->exists()) {
            abort(400, "You must submit atleast 1 file");
        }

        $assignment->setStudent($student);
        $submission->update(['status' => AssignmentSubmission::STATUS_SUBMITTED]);

        return $assignment->load('files', 'submissions');
    }

    public function gradeWork(Assignment $assignment, Request $request)
    {
        $this->validate($request, [
            'grade' => 'required|numeric|min:0|max:100',
            'student_id' => 'required|exists:users,id'
        ]);

        $student = Student::find($request->student_id);

        // $assignment->setStudent($student);

        $submission = AssignmentSubmission::where(['student_id' => $student->id, 'assignment_id' => $assignment->id])->first();

        if ($submission == null || $submission->status != AssignmentSubmission::STATUS_SUBMITTED) {
            abort(400, 'This assignment is not submitted');
        }

        $submission->update(['grade' => $request->grade, 'status' => AssignmentSubmission::STATUS_GRADED]);

        return $assignment->load('files', 'submissions');
    }
}
