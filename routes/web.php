<?php


use App\Http\Controllers\CodeController;
use App\Http\Controllers\ReferenceController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,

    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('codes', CodeController::class);
    Route::get('codes/create/modal', [CodeController::class, 'createModal'])
        ->name('codes.create.modal');

    Route::resource('references', ReferenceController::class);
    Route::post('references/create/modal', [CodeController::class, 'createReferenceModal'])
        ->name('references.create.modal');
});
