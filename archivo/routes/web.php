<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/file', function () {
    $file = User::find(2);
    $file->assignRole('admin');
    $file->load('roles');
    return view('file');
});
Route::post('/file/upload', [FileController::class, 'upload'])->name('file.upload');
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('/users')->group(function () {
        Route::get('/index', [UserController::class, 'index']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/store', [UserController::class, 'store']);
    });
    Route::prefix('/files')->group(function () {
        Route::get('/create', [FileController::class, 'create']);
        Route::get('/', [FileController::class, 'index']);
        // Route::post('/store', [UserController::class, 'store']);
    });
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('files', FileController::class);
});
Route::prefix('/api')->group(function () {

    Route::prefix('/users')->group(function () {
        Route::post('/store', [UserController::class, 'store']);
    });
    Route::prefix('/files')->group(function () {
        Route::post('/store', [FileController::class, 'store']);
    });

});
require __DIR__ . '/auth.php';
