<?php

use Illuminate\Support\Facades\Route;
use Ipsum\Admin\app\Http\Controllers\AdminController;
use Ipsum\Admin\app\Http\Controllers\Auth\ForgotPasswordController;
use Ipsum\Admin\app\Http\Controllers\Auth\LoginController;
use Ipsum\Admin\app\Http\Controllers\Auth\ResetPasswordController;
use Ipsum\Admin\app\Http\Controllers\LogController;
use Ipsum\Admin\app\Http\Controllers\SettingController;
use Ipsum\Admin\app\Http\Controllers\UserController;

Route::middleware(['web'])
    ->prefix(config('ipsum.admin.route_prefix'))
    ->group(function () {

        Route::get('', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        /* Login */
        Route::get('login', [LoginController::class, 'showLoginForm'])
            ->name('admin.login');
        Route::post('login', [LoginController::class, 'login']);
        Route::get('login/2af', [LoginController::class, 'showLoginForm2AF'])
            ->name('admin.login.2af');
        Route::post('login/{admin}/2af', [LoginController::class, 'login2AF'])
            ->name('admin.login.send2af');
        Route::get('logout', [LoginController::class, 'logout'])
            ->name('admin.logout');
        Route::post('logout', [LoginController::class, 'logout']);

        /* Remind */
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
            ->name('admin.password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('admin.password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
            ->name('admin.password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])
            ->name('admin.password.update');

        Route::get('adminUser/{admin}/2fa', [UserController::class, 'twoFactorAuthentification'])
            ->name('admin.2fa');
        Route::post('adminUser/{admin}/2fa', [UserController::class, 'twoFactorAuthentificationValidate'])
            ->name('admin.2faValidate');
        Route::delete('adminUser/{admin}/2fa', [UserController::class, 'twoFactorAuthentificationDelete'])
            ->name('admin.2faDelete');

        Route::get('adminUser/account', [UserController::class, 'account'])
            ->name('admin.account');

        Route::resource('adminUser', UserController::class)->parameters([
            'adminUser' => 'admin',
        ]);

        /* Settings */
        Route::get('setting', [SettingController::class, 'edit'])
            ->name('admin.setting.edit');
        Route::put('setting', [SettingController::class, 'update'])
            ->name('admin.setting.update');

        /* Logs */
        Route::get('log', [LogController::class, 'index'])
            ->name('admin.log.index');
        Route::get('log/preview/{file_name}', [LogController::class, 'preview'])
            ->name('admin.log.preview');
        Route::get('log/download/{file_name}', [LogController::class, 'download'])
            ->name('admin.log.download');
        Route::any('log/delete/{file_name}', [LogController::class, 'delete'])
            ->name('admin.log.delete');

    });
