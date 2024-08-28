<?php

use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserSettingController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::view('/admin/login','pages.auth.admin_login');

Route::get('/', [TaskController::class, 'dashboard'])->name('dashboard');

Route::group(['middleware' => ['auth']], function() {
});

 
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Account pages
    Route::prefix('account')->group(function () {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
        Route::put('settings/password', [SettingsController::class, 'changePassword'])->name('settings.changePassword');
    });

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('global-user-setting', [UserSettingController::class, 'globalUserSetting'])->name('global-user-setting');
    Route::post('storeglobalUserSetting', [UserSettingController::class, 'storeglobalUserSetting'])->name('store-global-setting');
    // User Settings

    Route::get('bot-settings', [UserSettingController::class, 'index'])->name('bot-settings');
    Route::get('add-bot-settings', [UserSettingController::class, 'create'])->name('add-bot-settings');
    Route::get('users/users-setting/{user_id}', [UserSettingController::class, 'user_settings'])->name('user_setting');
    Route::post('save-details', [UserSettingController::class, 'saveDetails'])->name('save-details');
    
    Route::post('users/users-setting/store', [UserSettingController::class, 'store'])->name('user_setting_store');
    Route::post('users/users-setting/delete-criterea', [UserSettingController::class, 'deleteCriterea'])->name('delete_criterea');
    Route::post('users/users-setting/delete-day-slot', [UserSettingController::class, 'deleteDaySlot'])->name('delete_day_slot');
    
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';