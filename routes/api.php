<?php

use App\Http\Controllers\Api\Account\AccountController as AccountAccountController;
use App\Http\Controllers\Api\Auth\AuthController as AuthAuthController;
use App\Http\Controllers\Api\Dashboard\Admin\DepartmentController as DashboardAdminDepartmentController;
use App\Http\Controllers\Api\Dashboard\Admin\LabelController as DashboardAdminLabelController;
use App\Http\Controllers\Api\Dashboard\Admin\LanguageController as DashboardAdminLanguageController;
use App\Http\Controllers\Api\Dashboard\Admin\PriorityController as DashboardAdminPriorityController;
use App\Http\Controllers\Api\Dashboard\Admin\SettingController as DashboardAdminSettingController;
use App\Http\Controllers\Api\Dashboard\Admin\StatusController as DashboardAdminStatusController;
use App\Http\Controllers\Api\Dashboard\Admin\UserController as DashboardAdminUserController;
use App\Http\Controllers\Api\Dashboard\Admin\UserRoleController as DashboardAdminUserRoleController;
use App\Http\Controllers\Api\Dashboard\CannedReplyController as DashboardCannedReplyController;
use App\Http\Controllers\Api\Dashboard\StatsController as DashboardStatsController;
use App\Http\Controllers\Api\Dashboard\TicketController as DashboardTicketController;
use App\Http\Controllers\Api\File\FileController as FileFileController;
use App\Http\Controllers\Api\Language\LanguageController as LanguageLanguageController;
use App\Http\Controllers\Api\Ticket\TicketController as UserTicketController;
use App\Http\Controllers\RSSController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\Admin\ServiceController;
use App\Http\Controllers\Api\Dashboard\Admin\ResidentController;
use App\Http\Controllers\Api\Dashboard\Admin\DepartmentController;


    Route::get('/dashboard/admin/departments/ticket-counts', [DepartmentController::class, 'ticketCounts']);

    Route::get('services', [ServiceController::class, 'index']);
    // Move the 'services' routes inside the 'dashboard/admin' prefix
    Route::group(['prefix' => 'dashboard/admin'], static function () {
        Route::get('/services', [ServiceController::class, 'publicIndex']); // Public endpoint
        Route::get('services', [ServiceController::class, 'index']);
        Route::get('services/{service}', [ServiceController::class, 'show']);
        Route::post('services', [ServiceController::class, 'store']);
        Route::put('services/{service}', [ServiceController::class, 'update']);
        Route::delete('services/{service}', [ServiceController::class, 'destroy']);
    });


        // List all residents
        Route::get('dashboard/admin/resident', [ResidentController::class, 'index'])
            ->name('resident.index');
        
        // Show details of a specific resident
        Route::get('dashboard/admin/resident/{id}', [ResidentController::class, 'show'])
            ->name('resident.show');
        
        // Create a new resident
        Route::post('dashboard/admin/resident', [ResidentController::class, 'store'])
            ->name('resident.store');
        
        // Update a specific resident
        Route::put('dashboard/admin/resident/{id}', [ResidentController::class, 'update'])
            ->name('resident.update');
        
        // Delete a specific resident
        Route::delete('dashboard/admin/resident/{id}', [ResidentController::class, 'destroy'])
            ->name('resident.destroy');
    

Route::group(['prefix' => 'lang'], static function () {
    Route::get('/', [LanguageLanguageController::class, 'list'])->name('language.list');
    Route::get('/{lang}', [LanguageLanguageController::class, 'get'])->name('language.get');
});

Route::group(['prefix' => 'auth'], static function () {
    Route::post('login', [AuthAuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthAuthController::class, 'logout'])->name('auth.logout');
    Route::post('register', [AuthAuthController::class, 'register'])->name('auth.register');
    Route::post('recover', [AuthAuthController::class, 'recover'])->name('auth.recover');
    Route::post('reset', [AuthAuthController::class, 'reset'])->name('auth.reset');
    Route::get('user', [AuthAuthController::class, 'user'])->name('auth.user');
    Route::post('check', [AuthAuthController::class, 'check'])->name('auth.check');
});

Route::group(['prefix' => 'account'], static function () {
    Route::post('update', [AccountAccountController::class, 'update'])->name('account.update');
    Route::post('password', [AccountAccountController::class, 'password'])->name('account.password');
});

Route::get('files/download/{uuid}', [FileFileController::class, 'download'])->name('files.download');
Route::apiResource('files', FileFileController::class)->only(['store', 'show']);
Route::get('rss', [RSSController::class, 'fetchRSS']);

Route::get('tickets/statuses', [UserTicketController::class, 'statuses'])->name('tickets.statuses');
Route::get('tickets/departments', [UserTicketController::class, 'departments'])->name('tickets.departments');
Route::post('tickets/attachments', [FileFileController::class, 'uploadAttachment'])->name('tickets.upload-attachment');
Route::post('tickets/{ticket}/reply', [UserTicketController::class, 'reply'])->name('tickets.reply');
Route::apiResource('tickets', UserTicketController::class)->except(['update', 'destroy']);

Route::group(['prefix' => 'dashboard'], static function () {

    Route::group(['prefix' => 'stats'], static function () {
        Route::get('count', [DashboardStatsController::class, 'count'])->name('dashboard.stats-count');
        Route::get('registered-users', [DashboardStatsController::class, 'registeredUsers'])->name('dashboard.stats.registered-users');
        Route::get('opened-tickets', [DashboardStatsController::class, 'openedTickets'])->name('dashboard.stats.opened-tickets');
    });

    Route::get('tickets/filters', [DashboardTicketController::class, 'filters'])->name('dashboard.tickets.filters');
    Route::get('tickets/canned-replies', [DashboardTicketController::class, 'cannedReplies'])->name('dashboard.tickets.canned-replies');
    Route::post('tickets/quick-actions', [DashboardTicketController::class, 'quickActions'])->name('dashboard.tickets.quick-actions');
    Route::post('tickets/attachments', [DashboardTicketController::class, 'uploadAttachment'])->name('dashboard.tickets.upload-attachment');
    Route::post('tickets/{ticket}/remove-label', [DashboardTicketController::class, 'removeLabel'])->name('dashboard.tickets.remove-label');
    Route::post('tickets/{ticket}/quick-actions', [DashboardTicketController::class, 'ticketQuickActions'])->name('dashboard.tickets.ticket-quick-actions');
    Route::post('tickets/{ticket}/reply', [DashboardTicketController::class, 'reply'])->name('dashboard.tickets.reply');
    Route::apiResource('tickets', DashboardTicketController::class)->except(['update']);

    Route::apiResource('canned-replies', DashboardCannedReplyController::class);

    Route::group(['prefix' => 'admin'], static function () {

        Route::get('departments/users', [DashboardAdminDepartmentController::class, 'users'])->name('dashboard.departments.users');
        Route::apiResource('departments', DashboardAdminDepartmentController::class);

        Route::apiResource('labels', DashboardAdminLabelController::class);
        Route::apiResource('statuses', DashboardAdminStatusController::class)->except(['store', 'delete']);
        Route::apiResource('priorities', DashboardAdminPriorityController::class)->except(['store', 'delete']);

        Route::get('users/user-roles', [DashboardAdminUserController::class, 'userRoles'])->name('users.user-roles');
        Route::apiResource('users', DashboardAdminUserController::class);

        Route::get('user-roles/permissions', [DashboardAdminUserRoleController::class, 'permissions'])->name('user-roles.permissions');
        Route::apiResource('user-roles', DashboardAdminUserRoleController::class);

        Route::get('settings/user-roles', [DashboardAdminSettingController::class, 'userRoles'])->name('settings.user-roles');
        Route::get('settings/languages', [DashboardAdminSettingController::class, 'languages'])->name('settings.languages');
        Route::get('settings/general', [DashboardAdminSettingController::class, 'getGeneral'])->name('settings.get.general');
        Route::post('settings/general', [DashboardAdminSettingController::class, 'setGeneral'])->name('settings.set.general');

        Route::post('languages/sync', [DashboardAdminLanguageController::class, 'sync'])->name('language.sync');
        Route::apiResource('languages', DashboardAdminLanguageController::class);

    });
});
