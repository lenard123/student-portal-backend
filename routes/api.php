<?php

use App\Http\Controllers\API\AcademicYearController;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FacultyController;
use App\Http\Controllers\API\GradeLevelController;
use App\Http\Controllers\API\MessageThreadController;
use App\Http\Controllers\API\SubjectController;
use Illuminate\Http\Request;
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

Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
    Route::get('/user', 'currentUser')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function() {

    Route::prefix('/announcements')->controller(AnnouncementController::class)->group(function() {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::put('/{announcement}', 'update');
        Route::delete('/{announcement}', 'destroy');
    });

    Route::prefix('/threads')->controller(MessageThreadController::class)->group(function() {
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

    Route::prefix('/academic-years')->controller(AcademicYearController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::get('/active', 'activeAcademicYear')->withoutMiddleware('auth:sanctum');
    });
});
