<?php

use App\Http\Controllers\api\Admin\AvatarController;
use App\Http\Controllers\Api\Admin\ChildManageController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\GameZoneController;
use App\Http\Controllers\Api\Admin\ParentController;
use App\Http\Controllers\Api\MissionController;
use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\ChildController;
use App\Http\Controllers\Api\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


    Route::controller(UserAuthController::class)->prefix('auth')->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login')->middleware('throttle:5,1');
        Route::post('/forgot-password', 'sendResetLink');
        Route::post('/verify-otp', 'verifyOtp');
        Route::post('/reset-password', 'resetPassword');
    });
    
    // Route::apiResource('/children', ChildController::class);
     
    /*
    |--------------------------------------------------------------------------
    | Protected Routes
    |--------------------------------------------------------------------------
    */
    
    Route::middleware('auth:sanctum')->group(function () {
    
        Route::post('/logout', [UserAuthController::class, 'logout']);

        // Child routes
        Route::prefix('children')->controller(ChildController::class)->group(function () {
                Route::get('/','index');
                Route::post('/','store');
                Route::get('/{id}','show');
                Route::put('/{id}','update');
                Route::delete('/{id}','destroy');
    
                // Update screen time for a specific child
                Route::post('/{id}/screen-time','updateScreenTime');
        });

        /*
        |--------------------------------------------------------------------------
        | Admin Routes
        |--------------------------------------------------------------------------
        */

        Route::prefix('admin')->middleware('admin')->group(function () {

            // mission routs
            Route::prefix('missions')->controller(MissionController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/', 'store');
                Route::get('/{id}', 'show');
                Route::put('/{id}', 'update');
                Route::delete('/{id}', 'destroy');
            });

            // avatar crud
            Route::prefix('avatars')->controller(AvatarController::class)->group(function () {
                    Route::get('/', 'index');
                    Route::post('/', 'store');
                    Route::get('/{avatar}', 'show');    
                    Route::put('/{avatar}', 'update');
                    Route::delete('/{avatar}', 'destroy');
            });

            // parent manaagement
            Route::prefix('parents')->controller(ParentController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('/{id}', 'show');
                Route::put('/{id}', 'update');
                Route::delete('/{id}', 'destroy');
            });

            // child management
            Route::prefix('children')->controller(ChildManageController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('/{id}', 'show');
                Route::put('/{id}', 'update');
                Route::delete('/{id}', 'destroy');
            });

            // Game-zone route
            Route::prefix('game-zone')->controller(GameZoneController::class)->group(function () {
                Route::get('/', 'index');
                    Route::post('/', 'store');
                    Route::get('/{gameZone}', 'show');
                    Route::put('/{gameZone}', 'update');
                    Route::delete('/{gameZone}', 'destroy');
            });

            Route::get('/dashboard', [DashboardController::class, 'index']);
        });

        // Route::post('/children/select', [SelectChildController::class, 'select']);

        // Route::post('/mission/{mission}/complete', [MissionController::class, 'complete']); 
        // Route::post('/children/{child}/mission/{mission}/complete', [MissionController::class, 'completeMission']); 
            
    });

        
    Route::middleware(['auth:sanctum', 'active.child'])->group(function () {

        Route::post('/mission/complete', [MissionController::class, 'completeMission']); 

    });

    // Route::get('/game-zone', [GameZoneController::class, 'index']);
    // Route::get('/game-zone/{id}', [GameZoneController::class, 'show']);

    Route::get('/games/all', [GameController::class, 'index']);
    Route::get('/games/{id}', [GameController::class, 'show']);