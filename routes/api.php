<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CollegeAddressController;
use App\Http\Controllers\CollegeQualificationController;

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

// Группа роутов для Colleges
Route::prefix('colleges')->group(function () {
    Route::get('/', [CollegeController::class, 'index']);
    Route::post('/', [CollegeController::class, 'store']);
    Route::get('/{college}', [CollegeController::class, 'show']);
    Route::put('/{college}', [CollegeController::class, 'update']);
    Route::delete('/{college}', [CollegeController::class, 'destroy']);

    Route::prefix('v1')->group(function () {
        //Добавление Вывод Квалификаций
        Route::post('/college-qualifications', [CollegeQualificationController::class, 'storeQualification']);
        Route::get('/qualificationsIndex', [CollegeQualificationController::class, 'getQualificationsByCollege']);
        Route::get('/specialitiesIndex', [CollegeQualificationController::class, 'indexSpecialities']);
        Route::get('/qualificationsIndexAdd', [CollegeQualificationController::class, 'indexQalifications']);
        Route::patch('/qualificationsUpdate', [CollegeQualificationController::class, 'updateQualification']);
        Route::delete('/qualificationsDelete', [CollegeQualificationController::class, 'deleteQualification']);
    });
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
