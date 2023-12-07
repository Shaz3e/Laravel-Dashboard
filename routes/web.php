<?php

// Facades
use Illuminate\Support\Facades\Route;

// Admin
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLogActivityController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\MailSettingsController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\AppSettingsController;
use App\Http\Controllers\Admin\EmailPageDesignController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\SupportTicketPriorityController;
use App\Http\Controllers\Admin\SupportTicketStatusController;
// Users
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserDashboardController;

// User Login
use App\Http\Controllers\User\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\PasswordResetLinkController;
use App\Http\Controllers\User\Auth\RegisteredUserController;
use App\Http\Controllers\User\Auth\EmailVerificationController;
use App\Http\Controllers\User\CustomerSupportController;

/*
|--------------------------------------------------------------------------
|                               Routes For All
|--------------------------------------------------------------------------
*/


/**
 * Errors
 * 
 */
Route::get('error/255', function () {
    return view('errors.255');
})->name('error.255');
Route::get('error/403', function () {
    return view('errors.403');
})->name('error.403');
Route::get('error/404', function () {
    return view('errors.404');
})->name('error.404');
Route::get('error/405', function () {
    return view('errors.405');
})->name('error.405');
Route::get('error/419', function () {
    return view('errors.419');
})->name('error.419');
Route::get('error/500', function () {
    return view('errors.500');
})->name('error.500');

/** 
 * States By Country
 * Cities By State
 */
Route::get('/get-country-code/{countryId}', [CountryController::class, 'getCountryCode']);
Route::get('/states/by-country/{country_id}', [StateController::class, 'getStatesByCountry'])->name('getStatesByCountry');
Route::get('/cities/by-state/{state_id}', [CityController::class, 'getCitiesByStates'])->name('getCitiesByStates');

/*
|--------------------------------------------------------------------------
|                               Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    Route::namespace('Auth')->middleware('guest:admin')->group(function () {
        /**
         * Login
         */
        Route::get('login', [AdminAuthenticatedSessionController::class, 'create']);
        Route::post('login', [AdminAuthenticatedSessionController::class, 'store'])->name('login');
    });


    Route::middleware('admin')->group(function () {

        /**
         * Admin Dashboard
         */
        // Route::get('', function () {
        //     return view('admin.dashboard');
        // });

        Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

        /**
         * Profile
         */
        Route::resource('profile', AdminProfileController::class);

        /**
         * Login As Client or Login Back as Admin
         */
        Route::get('clients/{id}/loginAs', [UserController::class, 'loginAs'])->name('clients.loginAs');
        Route::get('login-back', [UserController::class, 'loginBack'])->name('clients.login-back');

        /**
         * Clients
         */
        Route::resource('clients', UserController::class);

        /**
         * Support Tickets
         */
        Route::resource('support-tickets', SupportTicketController::class);

        /**
         * Support Ticket Status
         */
        Route::resource('support-tickets/manage/status', SupportTicketStatusController::class);

        /**
         * Support Ticket Priority
         */
        Route::resource('support-tickets/manage/priority', SupportTicketPriorityController::class);

        /**
         * Manage Users
         * Create New User
         * All Users
         */
        Route::resource('manage-staff', AdminController::class);

        /**
         * Manage Roles
         * Create New User
         * All Roles
         */
        Route::resource('manage-roles', RoleController::class);
        Route::post('manage-roles/{id}/permissions', [RoleController::class, 'updatePermissions'])->name('manage-roles.update-permissions');

        /** 
         * Location
         * Countries
         * States
         * Cities
         */
        Route::resource('locations/countries', CountryController::class);
        Route::resource('locations/states', StateController::class);
        Route::resource('locations/cities', CityController::class);


        /**
         * Mail Setting
         */
        Route::get('mail-settings/email-setup', [MailSettingsController::class, 'view']);
        Route::post('mail-settings/email-setup', [MailSettingsController::class, 'postData'])->name('mail-settings.post.data');


        /**
         * Email Page Design
         */
        Route::get('mail-settings/email-design', [EmailPageDesignController::class, 'view']);
        Route::post('mail-settings/email-design', [EmailPageDesignController::class, 'postData'])->name('email-design.post.data');


        /**
         * App Settings
         * Basic Settings
         * Brand Settings
         */

        // App Settings (Artisan Commands)
        Route::get('app-settings', [AppSettingsController::class, 'appSettings'])->name('app-settings');
        Route::post('app-settings', [AppSettingsController::class, 'appSettingsPost'])->name('app-settings.post');

        // Basic Settings
        Route::get('app-settings/basic', [AppSettingsController::class, 'BasicSettings']);
        Route::post('app-settings/basic', [AppSettingsController::class, 'BasicSettingsUpdate'])->name('app-settings-basic.update');

        // Theme & Notification Settings
        Route::get('app-settings/theme', [AppSettingsController::class, 'ThemeSettings']);
        Route::post('app-settings/theme', [AppSettingsController::class, 'ThemeSettingsUpdate'])->name('app-settings-theme.update');

        Route::get('app-settings/brand', [AppSettingsController::class, 'BrandSettings']);
        Route::post('app-settings/brand', [AppSettingsController::class, 'BrandSettingsUpdate'])->name('app-settings-brand.update');

        Route::get('app-settings/google-recaptcha', [AppSettingsController::class, 'GoogleRecaptchaSettings']);
        Route::post('app-settings/google-recaptcha', [AppSettingsController::class, 'GoogleRecaptchaSettingsUpdate'])->name('app-settings-google-recaptcha.update');

        /**
         * Log Activity
         */
        Route::get('log-activity', [AdminLogActivityController::class, 'index']);
        Route::get('log-activity/admin', [AdminLogActivityController::class, 'adminLogs']);
        Route::get('log-activity/user', [AdminLogActivityController::class, 'userLogs']);

        /**
         * Permissions & Routes
         */
        Route::get('app-permissions/routes', [PermissionController::class, 'appRoutes']);
        Route::resource('app-permissions', PermissionController::class);

        /**
         * Logout
         */
        Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});

/*
|--------------------------------------------------------------------------
|                               User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Registeration
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Forgot Password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Reset Password
    Route::get('reset-password/{email}/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    // Email Verification
    Route::get('verify-email/{email}/{token}', [EmailVerificationController::class, 'verify'])->name('verify-email');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    /**
     * User Dashboard
     */
    Route::get('/', [UserDashboardController::class, 'dashboard']);

    // Profile
    Route::get('profile', [UserProfileController::class, 'View'])->name('profile.view');
    Route::post('profile', [UserProfileController::class, 'Update'])->name('profile.update');

    // Customer Support
    Route::resource('customer-support', CustomerSupportController::class);
});
