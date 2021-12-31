<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StaffController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.jwt');
Route::get('/user', [AuthController::class, 'userProfile'])->middleware('auth.jwt');

Route::prefix('department')->group(function ($router) {
    Route::get("/", [DepartmentController::class, 'allDepartments']);
    Route::get("/{department}", [DepartmentController::class, 'getDepartment']);
    Route::patch("/{department}", [DepartmentController::class, 'updateDepartment']);
    Route::delete("/{department}", [DepartmentController::class, 'deleteDepartment']);
    Route::post("/add", [DepartmentController::class, 'createDepartment']);
});

Route::resource("staff", StaffController::class);

Route::post("/add/staff/department", [DepartmentController::class, 'addStaffToDepartment']);
Route::patch("/remove/staff/department", [DepartmentController::class, 'removeStaffFromDepartment']);

Route::patch("/make-hod", [DepartmentController::class, 'makeHeadOfDepartment']);
Route::patch("/unmake-hod", [DepartmentController::class, 'unMakeHeadOfDepartment']);
