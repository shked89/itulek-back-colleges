<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollegeController;
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

Route::prefix('api')->group(function () {
    // Группа роутов для Colleges
    Route::prefix('colleges')->group(function () {
        Route::get('/', [CollegeController::class, 'index']);
        Route::post('/', [CollegeController::class, 'store']);
        Route::get('/{college}', [CollegeController::class, 'show']);
        Route::put('/{college}', [CollegeController::class, 'update']);
        Route::delete('/{college}', [CollegeController::class, 'destroy']);
    });

    // Группа роутов для Faculties
    Route::prefix('faculties')->group(function () {
        Route::get('/', [FacultyController::class, 'index']);
        Route::post('/', [FacultyController::class, 'store']);
        Route::get('/{faculty}', [FacultyController::class, 'show']);
        Route::put('/{faculty}', [FacultyController::class, 'update']);
        Route::delete('/{faculty}', [FacultyController::class, 'destroy']);
    });

    // Группа роутов для StudyGroups
    Route::prefix('study-groups')->group(function () {
        Route::get('/', [StudyGroupController::class, 'index']);
        Route::post('/', [StudyGroupController::class, 'store']);
        Route::get('/{studyGroup}', [StudyGroupController::class, 'show']);
        Route::put('/{studyGroup}', [StudyGroupController::class, 'update']);
        Route::delete('/{studyGroup}', [StudyGroupController::class, 'destroy']);
    });

    // Группа роутов для Cities
    Route::prefix('cities')->group(function () {
        Route::get('/', [CityController::class, 'index']);
        Route::post('/', [CityController::class, 'store']);
        Route::get('/{city}', [CityController::class, 'show']);
        Route::put('/{city}', [CityController::class, 'update']);
        Route::delete('/{city}', [CityController::class, 'destroy']);
    });

    // Группа роутов для CollegeAddresses
    Route::prefix('college-addresses')->group(function () {
        Route::get('/', [CollegeAddressController::class, 'index']);
        Route::post('/', [CollegeAddressController::class, 'store']);
        Route::get('/{collegeAddress}', [CollegeAddressController::class, 'show']);
        Route::put('/{collegeAddress}', [CollegeAddressController::class, 'update']);
        Route::delete('/{collegeAddress}', [CollegeAddressController::class, 'destroy']);
    });
});
