<?php

use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DatabaseController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/about', [PortfolioController::class, 'about'])->name('about');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects.index');
Route::get('/projects/{project}', [PortfolioController::class, 'projectShow'])->name('projects.show');
Route::get('/blog', [PortfolioController::class, 'blog'])->name('blog.index');
Route::get('/blog/{post}', [PortfolioController::class, 'blogShow'])->name('blog.show');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contact', [PortfolioController::class, 'contactStore'])->name('contact.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('projects', AdminProjectController::class)->except('show');
    Route::resource('posts', AdminPostController::class)->except('show');
    Route::resource('skills', AdminSkillController::class)->except('show');
    Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::prefix('database')->name('database.')->group(function () {
        Route::get('/', [DatabaseController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/query', [DatabaseController::class, 'query'])->name('query');
        Route::get('/create-table', [DatabaseController::class, 'createTable'])->name('create-table');
        Route::post('/create-table', [DatabaseController::class, 'storeTable'])->name('store-table');

        Route::get('/{table}', [DatabaseController::class, 'show'])->name('show');
        Route::delete('/{table}', [DatabaseController::class, 'dropTable'])->name('drop-table');

        Route::get('/{table}/manage', [DatabaseController::class, 'manage'])->name('manage');
        Route::post('/{table}/columns', [DatabaseController::class, 'storeColumn'])->name('columns.store');
        Route::delete('/{table}/columns/{column}', [DatabaseController::class, 'dropColumn'])->name('columns.destroy');

        Route::get('/{table}/create', [DatabaseController::class, 'create'])->name('create');
        Route::post('/{table}', [DatabaseController::class, 'store'])->name('store');
        Route::get('/{table}/{id}/edit', [DatabaseController::class, 'edit'])->name('edit');
        Route::put('/{table}/{id}', [DatabaseController::class, 'update'])->name('update');
        Route::delete('/{table}/{id}', [DatabaseController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
