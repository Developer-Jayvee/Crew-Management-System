<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();



})->middleware('auth:sanctum');


Route::controller(APIUserController::class)->group(function(){
    Route::post('user/save','store');
    
});

Route::controller(APICrewController::class)->group(function(){
    Route::get('crewlist','show');
    Route::post('createcrew','store');
    Route::patch('profile/update','updateProfile');
    Route::post('document/update','updateDocument');
});
Route::controller(APISetupController::class)->group(function(){
    Route::prefix('rank')->group(function () {
        Route::post('create','createNewRank');
        Route::get('show','showRanks');
        Route::patch('update','updateRank');
        Route::delete('delete','deleteRank');
    });
    Route::prefix('document')->group(function () {
        Route::post('create','createNewDocumentType');
        Route::get('show','showDocumentTypes');
        Route::patch('update','updateDocumentType');
        Route::delete('delete','deleteDocumentType');
    });
    Route::prefix('usertypes')->group(function () {
        Route::post('create','createNewUserType');
        Route::get('show','showUserTypes');
    });
});

