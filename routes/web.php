<?php


use App\Http\Controllers\CodeController;
use App\Http\Controllers\ProjectController;
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
//
//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//
//    ]);
//});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', [CodeController::class, 'index'])->name('dashboard');

    Route::get('codes/tags/{code}/edit', [CodeController::class, 'editTagsModal'])
        ->name('codes.tags.edit');

    Route::get('codes/create/modal', [CodeController::class, 'createModal'])
        ->name('codes.create.modal');
    Route::get('codes/{code}/review/edit', [CodeController::class, 'reviewEdit'])
        ->name('codes.reviews.edit');
    Route::put('codes/{code}/review/update', [CodeController::class, 'reviewUpdate'])
        ->name('codes.reviews.update');
    Route::delete('codes/{code}/review/delete', [CodeController::class, 'reviewDelete'])
        ->name('codes.reviews.delete');

    Route::resource('codes', CodeController::class);

    Route::post('references/create-publisher/modal', [ReferenceController::class, 'createPublisher'])
        ->name('references.create-publisher.modal');
    Route::post('references/create/modal', [CodeController::class, 'createReferenceModal'])
        ->name('references.create.modal');

    Route::resource('references', ReferenceController::class);

    Route::get('projects/{project}/collection/edit', [ProjectController::class, 'editCollection'])
        ->name('projects.collection.edit');
    Route::put('projects/{project}/collection', [ProjectController::class, 'updateCollection'])
        ->name('projects.collection.update');
    Route::get('projects/{project}/collection/add', [ProjectController::class, 'showAddToCollection'])
        ->name('projects.showAddToCollection');
    Route::post('projects/{project}/collection/add', [ProjectController::class, 'storeAddToCollection'])
        ->name('projects.storeAddToCollection');
    Route::put('projects/{project}/collection/{code}', [ProjectController::class, 'updateCollection'])
        ->name('projects.updateCollection');
    Route::get('projects/{project}/collection/download', [ProjectController::class, 'generateWordFile'])
        ->name('projects.downloadCollection');
    Route::delete('projects/{project}/collection/{code}/delete', [ProjectController::class, 'deleteCollection'])
        ->name('projects.collection.delete');
    Route::resource('projects', ProjectController::class);
});
