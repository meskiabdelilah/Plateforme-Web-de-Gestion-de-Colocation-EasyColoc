<?php
namespace   App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Colocation\ColocationController;
use App\Http\Controllers\Colocation\InvitationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckBannedMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [ColocationController::class, 'index'])->name('dashboard');
    Route::post('/colocation', [ColocationController::class, 'store'])->name('colocation.store');
    Route::get('/colocation/{colocation}', [ColocationController::class, 'show'])->name('colocation.show');
    Route::post('/colocation/{colocation}/invite', [InvitationController::class, 'invite'])->name('colocation.invite');
    Route::get('/invitation/join/{token}', [InvitationController::class, 'join'])->name('invitations.join');
    Route::post('/invitation/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitation/{token}/reject', [InvitationController::class, 'reject'])->name('invitations.reject');
});


Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/users/{user}/toggle', [AdminDashboardController::class, 'toggleBan'])->name('admin.users.toggle-ban');
});

require __DIR__.'/auth.php';
