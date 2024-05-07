<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\GeneratorController;
use App\Http\Controllers\Api\GeneratorLogController;
use App\Http\Controllers\Api\KeyController;
use App\Http\Controllers\Api\KeyLogController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\WorkerController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DieselController;
use App\Http\Controllers\MemberController;
use App\Models\DieselLevel;
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

header("Access-Control-Allow-Origin: *");
header("Access-Control-Expose-Headers: Content-Length, X-JSON");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: *");


Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->controller(WorkerController::class)->prefix('/workers')->group(function () {
    Route::post('add', 'addWorker')->middleware('log.route');
    Route::get('', 'allWorkers');
    Route::put('{workerId}', 'updateWorker')->middleware('log.route');
    Route::post('upload-image', 'upload');
});

Route::middleware('auth:sanctum')->controller(UsersController::class)->prefix('/users')->group(function () {
    Route::post('add', 'addWorker')->middleware('log.route');
    Route::get('', 'allUsers');
    Route::put('{workerId}', 'updateWorker')->middleware('log.route');
    Route::post('upload-image', 'upload');
});

Route::middleware('auth:sanctum')->controller(GeneratorLogController::class)->prefix('/generator-usage')->group(function () {
    Route::post('turn-on', 'turnOnGenerator')->middleware('log.route');
    Route::post('turn-off', 'turnOffGenerator')->middleware('log.route');
});

Route::middleware('auth:sanctum')->controller(DieselController::class)->prefix('/diesel')->group(function () {
    Route::get('check', 'checkLevel')->middleware('log.route');
    Route::post('refuel', 'refuel')->middleware('log.route');
});

Route::middleware('auth:sanctum')->controller(GeneratorController::class)->prefix('/generators')->group(function () {
    Route::get('', 'generatorList')->middleware('log.route');
    Route::get('purposes', 'generatorPurpose')->middleware('log.route');
    // Route::put('{workerId}', 'updateWorker')->middleware('log.route');;
    // Route::post('upload-image', 'upload');
});

Route::get('approval-admins', [GeneratorController::class,  'approvalAdmins']);
Route::post('upload-image', [GeneratorLogController::class,  'storeImage']);

Route::middleware('auth:sanctum')->controller(DepartmentController::class)->prefix('/departments')->group(function () {
    Route::post('', 'addDepartment');
    Route::get('', 'allDepartments');
    Route::put('{workerId}', 'updateWorker');
    Route::post('upload-image', 'upload');
});

Route::middleware('auth:sanctum')->controller(KeyController::class)->prefix('/keys')->group(function () {
    Route::post('', 'store');
    Route::get('', 'allKeys');
    Route::delete('{keyId}', 'delete');
    Route::put('{keyId}', 'update');
});

Route::middleware('auth:sanctum')->controller(KeyLogController::class)->prefix('/key-logs')->group(function () {
    Route::post('pick', 'pickKey')->middleware('log.route');
    Route::post('drop', 'dropKey')->middleware('log.route');
    Route::get('', 'keyLogs');
});

Route::middleware('auth:sanctum')->controller(DashboardController::class)->prefix('dashboard')->group(function () {
    Route::get('items', 'index');
});

Route::middleware('auth:sanctum')->controller(MemberController::class)->prefix('members')->group(function () {
    Route::get('', 'memberList');
    Route::post('', 'addMember');
});

Route::middleware('auth:sanctum')->controller(AttendanceController::class)->prefix('attendance')->group(function () {
    Route::get('all', 'getAllAttendance');
    Route::post('sign-in', 'signinAttendance');
    Route::post('sign-out', 'signoutAttendance');
});
