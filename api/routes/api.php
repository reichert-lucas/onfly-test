<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\TravelOrderController as UserTravelOrderController;
use App\Http\Controllers\Admin\TravelOrderController as AdminTravelOrderController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\IsSuperAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'api.',
], function () {
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('choose-system/{system}', [AuthController::class, 'chooseSystem'])
                ->middleware([
                    'auth:sanctum',
                    IsSuperAdminMiddleware::class
                ])
                ->name('auth.choose-system');
    });

    Route::get('systems', [SystemController::class, 'index'])->name('systems.index')->middleware([
        'auth:sanctum',
        IsSuperAdminMiddleware::class
    ]);
    
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::group([
            'prefix' => 'auth',
            'as' => 'auth.'
        ], function () {
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('me', [AuthController::class, 'me'])->name('me');
            Route::put('update-profile', [AuthController::class, 'updateProfile'])->name('update-profile');
            Route::put('update-password', [AuthController::class, 'updatePassword'])->name('update-password');
            Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
        });

        Route::group([
            'prefix' => 'users',
            'as' => 'users.'
        ], function () {
            Route::get('travel-orders', [UserTravelOrderController::class, 'index'])->name('index');
            Route::post('travel-orders', [UserTravelOrderController::class, 'store'])->name('store');
            Route::get('travel-orders/{order}', [UserTravelOrderController::class, 'show'])->name('show');
        });

        Route::group([
            'prefix' => 'admins',
            'as' => 'admins.',
            'middleware' => [
                IsAdminMiddleware::class
            ]
        ], function () {
            Route::get('travel-orders', [AdminTravelOrderController::class, 'index'])->name('index');
            Route::get('travel-orders/{order}', [AdminTravelOrderController::class, 'show'])->name('show');
            Route::patch('travel-orders/{order}/change-status', [AdminTravelOrderController::class, 'changeStatus'])->name('change-status');
        });

        Route::resource('users', UserController::class)->middleware([
            IsAdminMiddleware::class
        ]);
    });
});


