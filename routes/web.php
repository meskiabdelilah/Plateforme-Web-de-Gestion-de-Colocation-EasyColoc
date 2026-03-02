<?php

namespace   App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Colocation\CategoryController;
use App\Http\Controllers\Colocation\ColocationController;
use App\Http\Controllers\Colocation\ExpenseController;
use App\Http\Controllers\Colocation\InvitationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckBannedMiddleware;
use App\Models\Category;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [ColocationController::class, 'index'])->name('dashboard');
    Route::resource('colocation', ColocationController::class)->only([
        'show',
        'store'
    ]);
    Route::post('/colocation/{colocation}/invite', [InvitationController::class, 'invite'])->name('colocation.invite');
    Route::get('/invitation/join/{token}', [InvitationController::class, 'join'])->name('invitations.join');
    Route::post('/invitation/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitation/{token}/reject', [InvitationController::class, 'reject'])->name('invitations.reject');
    /**
     * CRUD categories
     */
    Route::resource('categories', CategoryController::class)->only([
        'store',
        'update',
        'destroy'
    ]);

    /**
     * CRUD expenses (nested under colocation)
     */
    Route::resource('colocation.expenses', ExpenseController::class)->names([
        'index' => 'expenses.index',
        'create' => 'expenses.create',
        'store' => 'expenses.store',
        'show' => 'expenses.show',
        'edit' => 'expenses.edit',
        'update' => 'expenses.update',
        'destroy' => 'expenses.destroy'
    ]);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/users/{user}/toggle', [AdminDashboardController::class, 'toggleBan'])->name('admin.users.toggle-ban');
});

require __DIR__ . '/auth.php';
