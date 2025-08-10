<?php

use Illuminate\Support\Facades\Route;

Route::get('/','AdminController@index');
Route::controller(SignupController::class)->group(function(){
    Route::get('/signup','signupsetup');
    Route::post('signupuser','signup');
});

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'loginsetup');
    Route::post('/loginuser', 'login')->name('loginuser')->middleware('login');
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout','logout');
    });
});



Route::controller(StaffController::class)->prefix('staff')->group(function(){
    Route::get('/dashboard','dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::controller(GuestController::class)->prefix('crew')->group(function(){
        Route::get('/dashboard','dashboard');
    
        Route::prefix('document')->group(function () {
            Route::delete('{userid}','deleteDocument');
            Route::post('/upload','uploadDocument')->name('crew/upload'); 
        });
    });
    Route::controller(AdminController::class)->prefix('admin')->group(function(){
        Route::get('crew', 'dashboard');
        Route::get('configurations','config');
        Route::get('accounts','accountList');

        Route::get('documentDetails/{fileID}','getDocDetails');

        Route::post('uploadDoc','submitDocument');
        Route::prefix('crewlist')->group(function () {
            Route::delete('{ID}','deleteCrew');
         
        });
        // FOR CONFIGURATION MODULE
        Route::prefix('setup')->group(function () {
            Route::prefix('rank')->group(function () {
                Route::post('add','addNewRank')->name('add/Rank');
                Route::delete('{code}','deleteRank')->name('delete/Rank');
            });
            Route::prefix('document')->group(function () {
                Route::post('add','addNewDocument')->name('add/Document');
                Route::delete('{code}','deleteDocument')->name('delete/Document');
            });
            Route::prefix('usertype')->group(function () {
                Route::post('add','addNewUserType')->name('add/UserType');
                Route::delete('{code}','deleteUserType')->name('delete/UserType');
            });
        });


        Route::prefix('accounts')->group(function () {
            Route::delete('{username}','deleteUserAccount');
            Route::get('{username}','getUserAccountSetup');
            Route::put('update','updateAccount');
            Route::post('addNew','saveNewAccount');
        });
        
        Route::get('newaccountSetup','addNewUser');

        Route::delete('deleteFile/{id}','deleteFileSubmitted');
     });
});

// Route::get('/dashboard','AdminController@dashboard');