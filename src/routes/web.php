<?php

Route::group(
    [
        'middleware' => ['web'],
        'prefix' => config('ipsum.admin.route_prefix'),
        'namespace' => '\Ipsum\Admin\app\Http\Controllers'
    ],
    function() {

        Route::get('', array(
            "as" => "admin.dashboard",
            "uses" => "AdminController@dashboard",
        ));
    

        /* Login */
        Route::get("login", array(
            "as" => "admin.login",
            "uses" => "Auth\LoginController@showLoginForm",
        ));
        Route::post("login", array(
            "uses" => "Auth\LoginController@login",
        ));
        Route::get("login/2af", array(
            "as" => "admin.login.2af",
            "uses" => "Auth\LoginController@showLoginForm2AF",
        ));
        Route::post("login/{admin}/2af", array(
            "as" => "admin.login.send2af",
            "uses" => "Auth\LoginController@login2AF",
        ));
        Route::get("logout", array(
            "as" => "admin.logout",
            "uses" => "Auth\LoginController@logout",
        ));
        Route::post("logout", array(
            "uses" => "Auth\LoginController@logout",
        ));
        /* Remind */
        Route::get("password/reset", array(
            "as" => "admin.password.request",
            "uses" => "Auth\ForgotPasswordController@showLinkRequestForm",
        ));
        Route::post("password/email", array(
            "as" => "admin.password.email",
            "uses" => "Auth\ForgotPasswordController@sendResetLinkEmail",
        ));
        Route::get("password/reset/{token}", array(
            "as" => "admin.password.reset",
            "uses" => "Auth\ResetPasswordController@showResetForm",
        ));
        Route::post("password/reset", array(
            "as" => "admin.password.update",
            "uses" => "Auth\ResetPasswordController@reset",
        ));


        Route::get("adminUser/{admin}/2fa", array(
            "as" => "admin.2fa",
            "uses" => "UserController@twoFactorAuthentification",
        ));
        Route::post("adminUser/{admin}/2fa", array(
            "as" => "admin.2faValidate",
            "uses" => "UserController@twoFactorAuthentificationValidate",
        ));

        Route::delete("adminUser/{admin}/2fa", array(
            "as" => "admin.2faDelete",
            "uses" => "UserController@twoFactorAuthentificationDelete",
        ));

        Route::resource('adminUser', 'UserController')->parameters([
            'adminUser' => 'admin'
        ]);

        /* Settings */
        Route::get("setting", array(
            "as" => "admin.setting.edit",
            "uses" => "SettingController@edit",
        ));
        Route::put("setting", array(
            "as" => "admin.setting.update",
            "uses" => "SettingController@update",
        ));

        /* Logs */
        Route::get("log", array(
            "as" => "admin.log.index",
            "uses" => "LogController@index",
        ));
        Route::get("log/preview/{file_name}", array(
            "as" => "admin.log.preview",
            "uses" => "LogController@preview",
        ));
        Route::get("log/download/{file_name}", array(
            "as" => "admin.log.download",
            "uses" => "LogController@download",
        ));
        Route::any("log/delete/{file_name}", array(
            "as" => "admin.log.delete",
            "uses" => "LogController@delete",
        ));

    }
);