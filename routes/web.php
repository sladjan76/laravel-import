<?php
Route::view('/swagger', 'swagger');

Route::get('/', function () { return redirect('/login'); });
Route::get('/dashboard', function () { return redirect('/admin/home'); });
Route::get('/admin', function () { return redirect('/admin/home'); });

Route::get('email_verification/{verification_token}',  'Auth\LoginController@accountVerification');


Route::get('email_change/{email}/{user_id}/{verification_token}',  'UserController@emailChange');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('login', 'Auth\LoginController@login')->name('auth.login');
Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');
Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/home', 'HomeController@index');
    Route::resource('permissions', 'Admin\PermissionsController')->middleware('permission:users_manage');
    Route::post('permissions_mass_destroy',
        ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy'])
        ->middleware('permission:users_manage');
    Route::resource('roles', 'Admin\RolesController')->middleware('permission:users_manage');
    Route::post('roles_mass_destroy',
        ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy'])
        ->middleware('permission:users_manage');
    Route::resource('users', 'Admin\UsersController')->middleware('permission:users_manage');
    Route::post('users_mass_destroy',
        ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy'])
        ->middleware('permission:users_manage');


    // Import Form and Processing
    Route::get('/import/', 'Admin\ImportController@index')->name('imports.index');
    Route::post('/import/', 'Admin\ImportController@store')->name('imports.store');

    // Import History
    Route::get('/import_history', 'Admin\ImportHistoryController@index')->name('import_history.index');
    Route::delete('import_history/{id}',
        ['uses' => 'Admin\ImportHistoryController@destroy', 'as' => 'import_history.destroy']);
    Route::post('import_history_mass_destroy',
        ['uses' => 'Admin\ImportHistoryController@massDestroy', 'as' => 'import_history.mass_destroy']);
    Route::get('/import_history/errors/{id}', 'Admin\ImportHistoryController@errors')->name('import_history.errors');

    // Import Type Configuration (AJAX)
    Route::get('/import/config/{type}', 'Admin\ImportController@getConfig')->name('imports.config');
});
