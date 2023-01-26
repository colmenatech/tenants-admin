<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\TagTenantsController;
use App\Http\Controllers\Api\TenantTagsController;
use App\Http\Controllers\Api\UserTenantsController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TenantRequestController;
use App\Http\Controllers\Api\SubscriptionTenantsController;
use App\Http\Controllers\Api\TenantRequestTenantsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('subscriptions', SubscriptionController::class);

        // Subscription Tenants
        Route::get('/subscriptions/{subscription}/tenants', [
            SubscriptionTenantsController::class,
            'index',
        ])->name('subscriptions.tenants.index');
        Route::post('/subscriptions/{subscription}/tenants', [
            SubscriptionTenantsController::class,
            'store',
        ])->name('subscriptions.tenants.store');

        Route::apiResource('tags', TagController::class);

        // Tag Tenants
        Route::get('/tags/{tag}/tenants', [
            TagTenantsController::class,
            'index',
        ])->name('tags.tenants.index');
        Route::post('/tags/{tag}/tenants/{tenant}', [
            TagTenantsController::class,
            'store',
        ])->name('tags.tenants.store');
        Route::delete('/tags/{tag}/tenants/{tenant}', [
            TagTenantsController::class,
            'destroy',
        ])->name('tags.tenants.destroy');

        Route::apiResource('tenant-requests', TenantRequestController::class);

        // TenantRequest Tenants
        Route::get('/tenant-requests/{tenantRequest}/tenants', [
            TenantRequestTenantsController::class,
            'index',
        ])->name('tenant-requests.tenants.index');
        Route::post('/tenant-requests/{tenantRequest}/tenants', [
            TenantRequestTenantsController::class,
            'store',
        ])->name('tenant-requests.tenants.store');

        Route::apiResource('users', UserController::class);

        // User Tenants
        Route::get('/users/{user}/tenants', [
            UserTenantsController::class,
            'index',
        ])->name('users.tenants.index');
        Route::post('/users/{user}/tenants', [
            UserTenantsController::class,
            'store',
        ])->name('users.tenants.store');

        Route::apiResource('tenants', TenantController::class);

        // Tenant Tags
        Route::get('/tenants/{tenant}/tags', [
            TenantTagsController::class,
            'index',
        ])->name('tenants.tags.index');
        Route::post('/tenants/{tenant}/tags/{tag}', [
            TenantTagsController::class,
            'store',
        ])->name('tenants.tags.store');
        Route::delete('/tenants/{tenant}/tags/{tag}', [
            TenantTagsController::class,
            'destroy',
        ])->name('tenants.tags.destroy');
    });
