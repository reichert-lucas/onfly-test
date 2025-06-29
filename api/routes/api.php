<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
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
            'middleware' => 'auth:sanctum',
            'as' => 'auth.'
        ], function () {
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('me', [AuthController::class, 'me'])->name('me');
            Route::put('update-profile', [AuthController::class, 'updateProfile'])->name('update-profile');
            Route::put('update-password', [AuthController::class, 'updatePassword'])->name('update-password');
            Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
        });

        Route::resource('users', UserController::class)->middleware([
            'auth:sanctum',
            IsAdminMiddleware::class
        ]);
    });
});


