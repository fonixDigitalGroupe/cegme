<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/a-propos', function () {
    return view('a-propos');
})->name('a-propos');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/realisations', function () {
    return view('realisations');
})->name('realisations');

Route::get('/actualites', function () {
    return view('actualites');
})->name('actualites');

Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/dashboard', function () {
    // Rediriger les admins et éditeurs vers l'admin
    if (auth()->check() && auth()->user()->isAdminOrEditor()) {
        return redirect()->route('admin.dashboard');
    }
    // Pour les autres utilisateurs, afficher le dashboard normal
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'adminOrEditor'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Posts (Articles/Blog)
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    
    // Categories
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    
    // Tags
    Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);
});

// Admin Only Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Users
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});

require __DIR__.'/auth.php';
