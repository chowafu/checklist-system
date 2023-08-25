<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\FormGeneratorController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Login Page
Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Registration Page
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('Users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // 5S Checklist Form Page
    Route::get('/5S-Checklist', [UserController::class, 'show5SForm'])->name('5S-Checklist');

    // Create Check Sheet Page
    Route::prefix('/generate')->group(function () {
        Route::get('/', [FormGeneratorController::class, 'index'])->name('generate');
        Route::post('/', [FormGeneratorController::class, 'store'])->name('generate.store');
    });

    // Audit Trail Page
    Route::get('/audit', [AuditController::class, 'index'])->name('audit');

    // Pending Reports Page
    Route::prefix('/Pending-Reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('Pending-Reports');
        Route::put('/{status}/{id}', [ReportController::class, 'update'])->name('Pending-Reports.update');
    });

    // Model Manager Page
    Route::prefix('Models')->group(function () {
        Route::get('/', [ModelController::class, 'index'])->name('models.index');
        Route::get('/{id}/edit', [ModelController::class, 'edit'])->name('models.edit');
        Route::post('/', [ModelController::class, 'store'])->name('models.store');
        Route::put('/{id}', [ModelController::class, 'update'])->name('models.update');
        Route::delete('/', [ModelController::class, 'destroy'])->name('models.destroy');
    });
    // Form Submission Function
    Route::post('/submit-response', [ResponseController::class, 'store']);

    //Archives
    Route::get('/Archives', [ArchiveController::class, 'index'])->name('archives');

    // P-Touch Solder Form Page
    Route::get('/PTouch-Solder', [UserController::class, 'showPTouchForm'])->name('PTouch-Solder');

    //P-Touch-ICT Form Page
    Route::get('/PTouch-ICT', [UserController::class, 'showICTForm'])->name('PTouch-ICT');

    //Forms
    Route::get('Forms/{id}', [UserController::class, 'showForm'])->name('showForm');

    // User Manual
    Route::get('/UserManual', [UserController::class, 'showUserManual'])->name('UserManual');
});
