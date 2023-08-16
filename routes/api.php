<?php

use App\Http\Controllers\API\AcademicYearController;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EnrolleeController;
use App\Http\Controllers\API\FacultyController;
use App\Http\Controllers\API\GradeLevelController;
use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\MessageThreadController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\SectionsController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\StudentRegistrationController;
use App\Http\Controllers\API\SubjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
    Route::get('/user/{guard}', 'currentUser')->middleware('auth:sanctum');
    // Route::get('/student', 'currentStudent')->middleware('auth:sanctum');
    // Route::post('/student-logout', 'logoutStudent')->middleware('auth:sanctum');
});

Route::post('/students/send-otp', [StudentRegistrationController::class, 'sendOtp']);
Route::post('/students/register', [StudentRegistrationController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/student/subjects', [StudentController::class, 'subjects']);
    Route::post('/enrollment', [StudentRegistrationController::class, 'enroll']);
    Route::get('/enrollment/{enrollee}', [EnrolleeController::class, 'show']);
    Route::patch('/enrollment/{enrollee}/enroll', [EnrolleeController::class, 'enroll']);

    Route::prefix('/announcements')->controller(AnnouncementController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::put('/{announcement}', 'update');
        Route::delete('/{announcement}', 'destroy');
    });

    Route::prefix('/threads')->controller(MessageThreadController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{thread}/messages', 'messages');
        Route::post('/{thread}/messages', 'sendMessage');
    });

    Route::prefix('/faculties')->controller(FacultyController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::get('/{faculty}', 'show');
        Route::post('/{faculty}/subjects', 'addSubject');
    });

    Route::prefix('/subjects')->controller(SubjectController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
    });

    Route::prefix('/grade-levels')->controller(GradeLevelController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{level}', 'show');
        Route::post('/{level}/subjects', 'addSubject');
        Route::post('/{level}/fees', 'addFee');
    });

    Route::prefix('/academic-years')->controller(AcademicYearController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::get('/active', 'activeAcademicYear')->withoutMiddleware('auth:sanctum');
        Route::get('/{school_year}/sections', 'sections');
        Route::post('/{school_year}/sections', 'createSection');
        Route::get('/{school_year}/enrollees', 'enrollees');
    });

    Route::prefix('/sections')->controller(SectionsController::class)->group(function () {
        Route::get('/{section}', 'show');
        Route::post('/{section}/subjects', 'addSubject');
    });

    Route::get('/schedules/{schedule}', [ScheduleController::class, 'show']);
    Route::get('/schedules/{schedule}/posts', [ScheduleController::class, 'posts']);
    Route::post('/schedules/{schedule}/posts', [ScheduleController::class, 'createPost']);
    Route::get('/schedules/{schedule}/lessons', [ScheduleController::class, 'lessons']);
    Route::post('/schedules/{schedule}/lessons', [ScheduleController::class, 'createLesson']);
    Route::get('/schedules', [ScheduleController::class, 'index']);

    Route::get('/lessons/{lesson}', [LessonController::class, 'show']);
});

Route::get('/enrollment/id/download', [StudentRegistrationController::class, 'downloadRegistrationForm']);
Route::view('/test', 'pdf.registration-form');
